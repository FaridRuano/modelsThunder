<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){
    $query="SELECT pr_id as id, pr_name as name, pr_address as address,
    pr_phone as phone, pr_ruc as ruc, pr_saler as saler, pr_country as country,
    pr_email as email FROM th_providers";       
    $result=methodGet($query);      
    echo json_encode($result->fetchAll());     
    exit();
}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);
    $name=$_POST['name'];
    $ruc=$_POST['ruc'];
    $saler=$_POST['saler'];
    if($saler==null){
        $saler = 'S/I';
    }
    $phone=$_POST['phone'];
    if($phone==null){
        $saler = 'S/I';
    }
    $email=$_POST['email'];
    if($email==null){
        $email = 'S/I';
    }
    $address=$_POST['address'];
    if($address==null){
        $address = 'S/I';
    }
    $country=$_POST['country'];
    if($country==null){
        $country = 'S/I';
    }
    $query="INSERT INTO th_providers (pr_name, pr_address, pr_phone, pr_ruc, pr_saler, pr_country, pr_email)
    VALUES ('$name', '$address', '$phone', '$ruc', '$saler', '$country', '$email')";       
    $queryAutoIncrement="SELECT MAX(pr_id) as id from th_providers";    
    $result=methodPost($query, $queryAutoIncrement);     
    echo json_encode($result);     
    exit();
}
if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM th_providers WHERE pr_id = '$id'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}

header("HTTP/1.1 400 Bad Request")
?>