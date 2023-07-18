<?php
include '../../db/db.php';
date_default_timezone_set('America/Guayaquil');
header("Access-Control-Allow-Origin: *");
  
if($_SERVER['REQUEST_METHOD']=='GET'){
    $query="SELECT us_id as id, CONCAT(us_name, ' ',us_second) as name, us_user as user_name, us_email as email, us_permision as permision FROM th_users";       
    $result=methodGet($query);      
    echo json_encode($result->fetchAll());    
    exit();
}
if($_POST['METHOD']=='LOGIN'){
     unset($_POST['METHOD']);
     $username=($_POST['user']);  
     $password=($_POST['pass']);  
     $query="SELECT us_id as id, us_name as first, us_second as second, us_user as user, us_email as email, us_permision as permision FROM th_users where us_user='$username' AND us_pass='$password'";       
     $result=methodGet($query);      
     echo json_encode($result->fetch(PDO::FETCH_ASSOC));     
     exit();
}
if($_POST['METHOD']=='ADD'){
    unset($_POST['METHOD']);
    $name=ucfirst(strtolower($_POST['name']));
    $second=ucfirst(strtolower($_POST['last']));
    $email=($_POST['email']);
    $permision=($_POST['perm']);
    $username=($_POST['user_name']);
    $password=($_POST['password']);    
    $query="INSERT INTO th_users (us_name, us_second, us_user, us_email, us_permision, us_pass) 
    VALUES ('$name', '$second', '$username', '$email', '$permision', '12345')";       
    $queryAutoIncrement="SELECT MAX(us_id) as id from th_users";    
    $result=methodPost($query, $queryAutoIncrement);     
    echo json_encode($result);     
    exit();
}
if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);  
    $username=($_POST['username']);    
    $query="DELETE FROM th_users WHERE us_user = '$username'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}
if($_POST['METHOD']=='EDIT'){
    unset($_POST['METHOD']);  
    $id=($_POST['id']);
    $name=ucfirst(strtolower($_POST['name']));
    $second=ucfirst(strtolower($_POST['last']));
    $email=($_POST['email']);
    $permision=($_POST['perm']);
    $username=($_POST['username']);
    $password=($_POST['password']);   
    $query="UPDATE th_users SET us_name='$name', us_second='$second', us_user='$username', us_email='$email', us_permision='$permision' WHERE us_id='$id'";       
    $result=methodDelete($query);     
    echo json_encode($result);     
    exit();
}
 

header("HTTP/1.1 400 Bad Request")
?>