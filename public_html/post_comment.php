<?php
require(__DIR__."/../config/config.php");
if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
       if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            throw new Exception;
        }
    }catch(Exception $e){
        echo 'Invalid Token';
    }
    $post_cmt=new \MyApp\Model\Comment();
    $post_cmt->post_comment();
    header('Location:http://'.$_SERVER['HTTP_HOST']);
}