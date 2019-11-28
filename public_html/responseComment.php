<?php

require_once(__DIR__."/../config/config.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
    public function getResComment(){
        $rescmt=new \MyApp\Model\Comment();
        return $rescmt->getResponse();
    }
    header('Location:http://'.$_SERVER['HTTP_HOST']);
}
