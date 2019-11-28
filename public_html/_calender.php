<?php
ini_set('display_errors',1);
require(__DIR__.'/../config/config.php');

$calender=new \MyApp\Controller\Calender();

if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
        $res=$calender->setState();
        header('Content-Type:application/json');
        echo json_encode($res);    
        exit;
    }catch(\Exception $e){
        header($_SERVER['SERVER_PROTOCOL'].'500 Internal Server Error',true,500);
        echo $e->getMessage();
    }
}    