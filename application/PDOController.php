<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once "DB_PASS.php";
global $db;
try {
    $db = new PDO(TEXT, LOGIN,PASSWORD);
}
catch (PDOException $e) {
    print "Failed to connect database!: " . $e->getMessage() . "<br/>";
}

function getCommand($command, $params = []){
    global $db;
    $statement = $db->prepare($command);
    $paramsArray = [];
    foreach ($params as $key=>$param){
        $paramsArray[":$key"] = $param;
    }

    $statement->execute($paramsArray);

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function putCommand($command, $params = []){
    global $db;
    $statement = $db->prepare($command);
    $paramsArray = [];
    foreach ($params as $key=>$param){
        $paramsArray[":$key"] = $param;
    }

    $statement->execute($paramsArray);
    if($statement->errorInfo()[0] != '00000'){
        print_r($statement->errorInfo());
        return $statement->errorInfo();
    }
}

function insertCommand($command,$params = []){
    global $db;
    $statement = $db->prepare($command);
    $paramsArray = [];
    foreach ($params as $key=>$param){
        $paramsArray[":$key"] = $param;
    }

    $statement->execute($paramsArray);
    if($statement->errorInfo()[0] != '00000'){
        print_r($statement->errorInfo());
        testQuery($command,$params);
        return $statement->errorInfo();
    }
    $records = $db->query("SELECT LAST_INSERT_ID()");
    $return=$records->fetchAll(PDO::FETCH_ASSOC);

    return $return[0]['LAST_INSERT_ID()'];
}
