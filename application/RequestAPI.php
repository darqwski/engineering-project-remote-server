<?php
class RequestAPI
{
    public static function getBody(){
        return file_get_contents('php://input');
    }
    public static function getJSON(){
        return json_decode( file_get_contents('php://input'), true);
    }
    public static function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
}