<?php
namespace MyApp\Controller;

class Register extends \MyApp\Controller{
    public function run(){
        //ログイン状態か否か検証、isLoggedInはController内で定義
        if($this->isLoggedIn()){
            //ログインしている場合TOPページへリダイレクト
            header("Location:http://".$_SERVER['HTTP_HOST']);
            exit;
        }
        if($_SERVER["REQUEST_METHOD"]==='POST'){
            $this->postProcess();
        }
    }
    protected function postProcess(){
        //送られてきたformが妥当か検証
        try{
            $this->_validate();
        }catch(\MyApp\Exception\InvalidUserName $e){
            //setError、setValue、hasErrorはController.php内で定義
            $this->setError('username',$e->getMessage());
        }catch(\MyApp\Exception\InvalidPassword $e){
            $this->setError('password',$e->getMessage());
        }
        
        $this->setValue('username',$_POST['username']);
        
        if($this->hasError()){
            return;
        }else{
            //エラーがなければユーザーを作成
            try{
                //データベース処理はModel内で行うためそちらを呼び出す
                $userModel=new \MyApp\Model\User();
                $userModel->create([
                    'username'=>$_POST['username'],
                    'password'=>$_POST['password']
                ]);   
            }catch(\MyApp\Exception\DuplicateUserName $e){
                $this->setError('username',$e->getMessage());
                return;
            }
            //ユーザー生成が完了した場合ログイン画面にリダイレクト
            header("Location:http://".$_SERVER['HTTP_HOST']."/redirect.php");
            exit;
        }
    }
    private function _validate(){
        if(!isset($_POST['token']) || $_SESSION['token']!==$_POST['token']){
            echo "Invalid Token!";
        }
        //送られてきたデータが半角英数字のみか検証
        if(!preg_match("/\A[a-zA-Z0-9]+\z/",$_POST['username'])){
            throw new \MyApp\Exception\InvalidUserName();
        }elseif(!preg_match("/\A[a-zA-Z0-9]+\z/",$_POST['password'])){
            throw new \MyApp\Exception\InvalidPassword();
        }
    }
}