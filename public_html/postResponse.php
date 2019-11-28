<?php

require_once(__DIR__."/../config/config.php");

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['resComment'])){
    $resComment=new \MyApp\Controller\Comment();
    $response=$resComment->postResponse();
}
header('Location:http://'.$_SERVER['HTTP_HOST']);
