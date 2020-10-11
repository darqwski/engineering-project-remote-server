<?php

    include_once "application/PDOController.php";
    include_once "application/RequestAPI.php";
    include_once "application/DataStream.php";
    session_start();
    $method = RequestAPI::getMethod();
    if(isset($_SESSION['userId'])){
        header("Location: dashboard/");
    }
    if($method == "POST") {
        if(isset($_POST['login']) && $_POST['password']){
            $user = (new DataStream())
                ->getFromQuery("SELECT userId, login, password FROM users WHERE login = :login",["login"=>$_POST['login']])
                ->get();
            if(count($user) == 0){
                echo "Nie ma takiego użytkownika w bazie";
            } else {
                if(md5($_POST['password']) == $user[0]["password"]){
                    echo "ZALOGOWANO";
                    $_SESSION['userId'] = $user[0]['userId'];
                    $_SESSION['login'] = $user[0]['login'];
                    header("Location: dashboard/");
                } else {
                    echo "Podane hasło jest błędne";
                }
            }
        }
    }
    print_r($_SESSION);
    ?>

<form method="post">
    <input name="login" />
    <input name="password" type="password" />
    <button type="submit">LOGIN</button>
</form>