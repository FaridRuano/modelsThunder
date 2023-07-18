<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query="SELECT inde_id as id, inde_cod as serial, inde_com_p as comp, inde_date as date FROM th_inv_det WHERE inde_pro_p = '$id'";
        $result=methodGet($query);      
        echo json_encode($result->fetchAll());     
    }else if(isset($_GET['METHOD'])){
        if($_GET['METHOD']=='SALE'){
            $query="SELECT in_id as id, in_name as name, in_price as price FROM th_inventory";
            $result=methodGet($query);      
            echo json_encode($result->fetchAll()); 
        }    
    }else{
        $query="SELECT a.in_id AS id, a.in_name AS name, a.in_price AS price, COUNT(c.inde_id) AS quant, b.pr_name 
                AS provider, a.in_descrip AS descrip FROM th_inventory AS a 
                LEFT JOIN th_inv_det AS c ON a.in_id = c.inde_pro_p
                JOIN th_providers AS b ON a.in_provider = b.pr_id
                WHERE a.in_type='PROD'
                GROUP BY a.in_id, a.in_name, a.in_price, b.pr_name, a.in_descrip;";       
        $result=methodGet($query);      
        echo json_encode($result->fetchAll());     
    }
    exit(); 
}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);
    $name=$_POST['name'];
    $price=$_POST['price'];    
    $provider=($_POST['provider']);
    $descrip=($_POST['descrip']);  

    $query="INSERT INTO th_inventory (in_name, in_price, in_provider, in_descrip, in_type) 
    VALUES ('$name', '$price', '$provider', '$descrip', 'PROD')";       
    $result=methodPut($query);     
    echo json_encode($result);     
    exit();
}
if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id = $_POST['id'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $quant=$_POST['quant'];
    if($quant=='' || $quant==null){
        $quant=0;
    }
    $provider=($_POST['provider']);
    $descrip=($_POST['descrip']);  


    $query="UPDATE th_inventory SET in_name = '$name', in_price='$price', in_quant = '$quant',
    in_descrip = '$descrip', in_provider = '$provider' WHERE in_id = '$id'";       
    $result=methodPut($query);     
    echo json_encode(true);     
    exit();
}
if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM th_inventory WHERE in_id = '$id'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}

if($_POST['METHOD']=='DELITE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM th_inv_det WHERE inde_id = '$id'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}

if($_POST['METHOD']=='INDEADD'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $serial=$_POST['serial'];
    $fac=$_POST['fac'];
    $date=$_POST['date'];

    $query="INSERT INTO th_inv_det (inde_pro_p, inde_cod, inde_com_p, inde_date) 
    VALUES ('$id', '$serial', '$fac', '$date')";
    $result=methodPut($query);
    echo json_encode($result);
    exit();
}

header("HTTP/1.1 400 Bad Request")
?>