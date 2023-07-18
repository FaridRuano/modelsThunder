<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){

    $query="SELECT in_id as id, in_name as name, in_descrip as descrip, in_price as price FROM th_inventory WHERE in_type = 'SERV'";
    $result=methodGet($query);      
    echo json_encode($result->fetchAll());     
    exit(); 

}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);
    $name=$_POST['name'];
    $price=$_POST['price'];
    $descrip=$_POST['descrip'];    

    $query="INSERT INTO th_inventory (in_name, in_descrip, in_price, in_provider,in_type) 
    VALUES ('$name', '$descrip', '$price', 0,'SERV')";
    $queryAutoIncrement="SELECT MAX(se_id) as id from th_services";
    $result=methodPost($query, $queryAutoIncrement);     
    echo json_encode($result);     
    exit();
    
}
if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id = $_POST['id'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $descrip=$_POST['descrip'];   

    $query="UPDATE th_inventory SET in_name='$name', in_descrip as '$descrip', in_price='$price'
    WHERE in_id='$id'";
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
 

header("HTTP/1.1 400 Bad Request")
?>