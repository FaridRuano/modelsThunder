<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['METHOD'])){
        if($_GET['METHOD'] == 'NUM'){
            $query="SELECT MAX(sa_no) as num FROM th_sale";
            $result=methodGet($query);      
            echo json_encode($result->fetch());
        }else if($_GET['METHOD'] == 'DET'){
            $query="SELECT a.sd_sale_id as sid, b.in_name as name, sd_cant as cant, sd_price as price, sd_sub as sub FROM th_sale_det as a, th_inventory as b WHERE a.sd_pro = b.in_id";
            $result=methodGet($query);      
            echo json_encode($result->fetchAll());
        }
    }else{
        $query="SELECT sa_id as id, sa_no as num,sa_cli as cli, sa_subtotal as subtotal, sa_desct as desct, sa_iva as iva, sa_total as total, sa_no as num, sa_date as date FROM th_sale";
        $result=methodGet($query);      
        echo json_encode($result->fetchAll());     
    }
    exit(); 
}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);
    $cli = $_POST['cli'];
    $subtotal = $_POST['sub'];
    $desct = $_POST['desct'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    $num = $_POST['no'];
    $date = date("Y-m-d");    
    $jsonData = $_POST['items'];
    $items = json_decode($jsonData, true);
    
    $query="INSERT INTO th_sale (sa_cli, sa_subtotal, sa_desct, sa_iva, sa_total, sa_no, sa_date)
            VALUES ('$cli', '$subtotal', '$desct', '$iva','$total', '$num', '$date')";
    $result=methodPut($query);     
    
    if(is_array($items)){
        foreach($items as $item){
            $prod = $item['id'];
            $price = $item['price'];
            $cant = $item['cant'];
            $subtotal1 = $price * $cant;

            $query="INSERT INTO th_sale_det (sd_sale_id, sd_pro, sd_cant, sd_price, sd_sub)
                    VALUES ('$num', '$prod', '$cant', '$price','$subtotal1')";
            $result2=methodPut($query);     
        }
    }
    echo json_encode($result);     
    exit();
    
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM th_sales WHERE sa_id = '$id'";
    $result=methodDelete($query);
    echo json_encode($result);     
    exit();
}
 

header("HTTP/1.1 400 Bad Request")
?>