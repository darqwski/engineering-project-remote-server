<?php
include_once "../../application/PDOController.php";
include_once "../../application/RequestAPI.php";
include_once "../../application/DataStream.php";

session_start();

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
        if(!is_array($result)){
            echo json_encode(["message"=>"Program zmieniono pomyslnie"]);
        }
    }
}
if($method == "GET"){
    $userInfo = getCommand("
SELECT users.*, programs.programDescription 
FROM users 
INNER JOIN programs ON programs.programId = users.program
WHERE users.userId = $_SESSION[userId]
");
    $programs = getCommand("SELECT * FROM programs ");
    echo json_encode([
        "userInfo"=>$userInfo,
        "programs"=>$programs
    ]);
}