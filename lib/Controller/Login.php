<?php
namespace MyApp\Controller;

class Login extends \MyApp\Controller{
    public function run(){
        //ここではログインしていた場合TOPページにリダイレクトされるよう設定
        if($this->isLoggedIn()){
            header("Location:http://".$_SERVER['HTTP_HOST']);
            exit;
        }
        //login.phpのformがsubmitされると$_SERVER["REQUEST_METHOD"]の値がPOSTに
        if($_SERVER["REQUEST_METHOD"]==='POST'){
            $this->postProcess();
        }
    }
    protected function postProcess(){
        //login.phpから送られてきた内容が妥当か検証
        try{
            //このファイル内の$this->_validate()で$_POST['token]と$_SESSION['token]が等しいか
            //formの中のusernameとパスワードが埋められているか検証
            $this->_validate();
        }catch(\MyApp\Exception\EmptyPost $e){
            //例外が発生した際の処理は名前空間Exceptionを作成しそちらで振り分け
            //setErrorはController.phpに記載
            $this->setError('login',$e->getMessage());
        }
        //setValueもController.phpに記載
        $this->setValue('username',$_POST['username']);
        
        //エラーが発生した場合、Controller内のsetError()にエラー内容がセットされ、
        //setErrorがセットされている場合hasError()はtrueになる
        if($this->hasError()){
            return;
        }else{
            //エラーがなければログイン処理
            try{
                //データベース処理は名前空間Model内に記載しているためModel\User()をインスタンス化
                $userModel=new \MyApp\Model\User();
                //login()はModel/User.phpで定義しusernameとpasswordを受け取って該当のユーザーのデータをテーブルから引っ張る
                $user=$userModel->login([
                    'username'=>$_POST['username'],
                    'password'=>$_POST['password']
                ]);
            }catch(\MyApp\Exception\UnmatchUserNameOrPassword $e){
                $this->setError('login',$e->getMessage());
                return;
            }
            //session_idを再生成し、セキュリティ強化
            session_regenerate_id(true);
            //この時点で$_SESSION['me']にユーザー情報を格納し
            //その場合isLoggedIn()はtrueを返すようになるためログイン状態と判定
            $_SESSION['me']=$user;
            //ログイン画面にリダイレクト
            header("Location:http://".$_SERVER['HTTP_HOST']);
            exit;
        }
    }
    private function _validate(){
        //ここでformから送られてきた$_POST['token]と$_SESSION['token']を比較検証
        if(!isset($_POST['token']) || $_SESSION['token']!==$_POST['token']){
            echo "Invalid Token!";
            exit;
        }
        //form内のデータが正しく送られているかも検証
        if(!isset($_POST['username']) || !isset($_POST['password'])){
            echo "Invalid Form!";
            exit;
        }
        if($_POST['username']==="" || $_POST['password']===""){
            throw new \MyApp\Exception\EmptyPost();
        }
    }
}