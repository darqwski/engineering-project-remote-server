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
    $userId= $_SESSION['userId'];
    $inputs=json_decode($_POST['inputs'], true);
    putCommand("
UPDATE `devices` SET `value` = :window WHERE `devices`.`deviceId` = 1;
UPDATE `devices` SET `value` = :blinds WHERE `devices`.`deviceId` = 2;
UPDATE `devices` SET `value` = :furnace WHERE `devices`.`deviceId` = 3;
UPDATE `devices` SET `value` = :temperature WHERE `devices`.`deviceId` = 4;
UPDATE `devices` SET `value` = :isRaining WHERE `devices`.`deviceId` = 5;
UPDATE `devices` SET `value` = :ac WHERE `devices`.`deviceId` = 7;
",[
    'window'=>$inputs['window'],
    'blinds'=>$inputs['blinds'],
    'furnace'=>$inputs['furnace'],
    'temperature'=>$inputs['temperature'],
    'ac'=>$inputs['AC'],
    'isRaining'=>$inputs['is_raining'] ? 'true' : 'false',
    ]);
}
if($method == "GET"){
    echo (new DataStream())
        ->getFromQuery("SELECT * FROM devices")
        ->toJson();
}