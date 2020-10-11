<?php
include_once "../../application/PDOController.php";
include_once "../../application/RequestAPI.php";
include_once "../../application/DataStream.php";

$method = RequestAPI::getMethod();

if($method == "POST") {
    if(isset($_POST['login']) && $_POST['password']){
        $user = (new DataStream())
            ->getFromQuery("SELECT userId, login, password FROM users WHERE login = :login",["login"=>$_POST['login']])
            ->get();
        if(count($user) == 0){
            echo json_encode(['message'=>"Nie ma takiego użytkownika w bazie"]);
        } else {
            if(md5($_POST['password']) == $user[0]["password"]){
                $_SESSION['userId'] = $user[0]['userId'];
                $_SESSION['login'] = $user[0]['login'];
                echo json_encode([
                    "userId"=>$user[0]['userId'],
                    "login"=>$user[0]['login']
                ]);
            } else {
                echo json_encode(['message'=>"Podane hasło jest błędne"]);
            }
        }
    }
}