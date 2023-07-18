<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){    
    $query="SELECT cl_id as id, cl_dni as dni, CONCAT(cl_name, ' ', cl_last) as name, cl_email as email, cl_dir as dir, cl_phone as phone FROM th_clients";
    $result=methodGet($query);
    echo json_encode($result->fetchAll());    
    exit(); 
}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);

    $dni = ($_POST['dni']);
    $name = ucfirst(strtolower($_POST['name']));
    $last = ucfirst(strtolower($_POST['last']));
    $email = ($_POST['email']);
    $dir = ($_POST['dir']);
    $phone = ($_POST['phone']);

    $stmt="INSERT INTO th_clients (cl_dni, cl_name, cl_last, cl_email, cl_dir, cl_phone) VALUES ('$dni', '$name',
    '$last', '$email', '$dir', '$phone')";
    $stmtAuIn="SELECT MAX(cl_id) as id from th_clients";    
    $result=methodPost($stmt, $stmtAuIn);     
    echo json_encode($result);     

    exit();
}
if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);

    $id = ($_POST['id']);
    $name = ucfirst(strtolower($_POST['name']));
    $last = ucfirst(strtolower($_POST['last']));
    $email = ($_POST['email']);
    $dir = ($_POST['dir']);
    $phone = ($_POST['phone']);

    $query="UPDATE th_clients SET cl_name='$name', cl_last='$last', cl_email='$email', cl_dir='$dir',
    cl_phone='$phone' WHERE cl_id = '$id'";       
    $result=methodPut($query);     
    echo json_encode(true);     
    exit();
}
if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM th_clients WHERE cl_id = '$id'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}
header("HTTP/1.1 400 Bad Request")
?>