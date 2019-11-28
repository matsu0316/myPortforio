<?php
//名前空間を設定
namespace MyApp\Controller;

//ControllerクラスをIndexへ継承
class Index extends \MyApp\Controller{
    public function run(){
        //Controller.php内で定義したisLoggedIn()関数を使いログインしているか確認
        //ログインしていない場合は$this->isLoggedInはfalseとなりlogin.phpへリダイレクト
        if(!$this->isLoggedIn()){
            //$_SERVER['HTTP_HOST']にはTOPページのIPアドレスとポート番号が格納
            header("Location:http://".$_SERVER['HTTP_HOST']."/login.php");
            exit;
        }
        $userModel= new \MyApp\Model\User();
        $this->setValue('users',$userModel->findAll());
    }
}