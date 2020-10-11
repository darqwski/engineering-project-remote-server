<?php
include_once "../../application/PDOController.php";
include_once "../../application/RequestAPI.php";
include_once "../../application/DataStream.php";

$method = RequestAPI::getMethod();
if(!isset($_SESSION['userId'])){
    header('Location: ../');
}
if($method == "POST"){
    if(isset($_POST['program'])){
        $result = putCommand("UPDATE `users` SET `program` = :program WHERE `userId` = :userId",[
            "userId"=>$_SESSION['userId'],
            'program' => $_POST['program']
        ]);
    }
}