<?php
header("Content-Type: text/html;charset=utf-8"); 

$pdo=null;
$host="localhost";
$user="root";
$pass="";
$db="thunder_db";

function conect(){
    try{
        $GLOBALS['pdo']=new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db']."", $GLOBALS['user'], $GLOBALS['pass']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        print "Error!: No se pudo conectar a la db ".$db."<br/>";
        print "\n Error!: ".$e."<br/>";
        die();
    }
}

function disconnect(){
    $GLOBALS['pdo']=null;
}

function methodGet($query){
    try{
        conect();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        disconnect();         
        return $statement;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function methodPost($query, $queryAutoIncrement){
    try{
        conect();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $idAutoIncrement=methodGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $result=array_merge($idAutoIncrement, $_POST);
        $statement->closeCursor();
        disconnect();
        return $result;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function methodPut($query){
    try{
        conect();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $result=array_merge($_GET, $_POST);
        $statement->closeCursor();
        disconnect();
        return $result;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function methodDelete($query){
    try{
        conect();
        $statement = $GLOBALS['pdo']->prepare($query);
        $statement->execute();
        $result=array_merge($_GET, $_POST);
        $statement->closeCursor();
        disconnect();
        return true;
    }catch(Exception $e){
        die("Error: ".$e);
        return false;
    }
}
?>