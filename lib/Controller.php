<?php
namespace MyApp;
class Controller{
    private $_values;
    private $_errors;
    public function __construct(){
        //$_SESSION['token']が定義されていない場合新しく$_SESSION['token']を生成
        if(!isset($_SESSION['token'])){
            $_SESSION['token']=bin2hex(openssl_random_pseudo_bytes(16));
        }
        if(!isset($_SESSION['countComment'])){
            $_SESSION['countComment']=0;
        }
        //定義済みクラスstdClassを使い変数をオブジェクト化できる
        $this->_errors=new \stdClass();
        $this->_values=new \stdClass();
    }
    //名前空間Controller以下の名前空間で使えるようprotectedで定義
    protected function setValue($key,$value){
    //Login.phpで$keyに'username'、$valueに$_POST['username']を格納するために使用
        $this->_values->$key=$value;
    }
    //ページ内で使うためpublicに
    public function getValue(){
        return $this->_values;
    }
    //エラーの処理を振り分けるため_errors内に格納
    protected function setError($key,$error){
        $this->_errors->$key=$error;
    }
    public function getError($key){
        return isset($this->_errors->$key) ?  $this->_errors->$key : '';
    }
    //getErrorがセットされている場合hasErrorがtrueを返す
    protected function hasError(){
        return !empty(get_object_vars($this->_errors));
    }
    //ログインした場合＄_SESSION['me']に自分の情報が入るため、その中身の有無でログインしているか否かを管理
    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }
    //$this->isLoggedIn()がtrueの場合＄_SESSION['me']を返す
    public function me(){
        return $this->isLoggedIn() ? $_SESSION['me'] : null;
    }
}