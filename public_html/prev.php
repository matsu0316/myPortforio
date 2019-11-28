<?php

require_once(__DIR__."/../config/config.php");
if($_SERVER['REQUEST_METHOD']==='POST'){
    if($_SESSION['countComment']>=$_POST['maxComment']){
        header('Location:http://'.$_SERVER['HTTP_HOST']);
        exit;
    }
    $_SESSION['countComment']+=1;
    header('Location:http://'.$_SERVER['HTTP_HOST']);
    exit;
}