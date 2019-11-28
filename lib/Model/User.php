<?php

namespace MyApp\Model;

class User extends \MyApp\Model{
    public function create($values){
        //ユーザーを生成
        $stmt=$this->db->prepare("insert into users (username,password,created,modified) value (:username,:password,now(),now())");
        $res=$stmt->execute([
            ':username'=>$values['username'],
            //password_hashでパスワードを暗号化しこちらからもわからなくなるように設定
            ':password'=>password_hash($values['password'],PASSWORD_DEFAULT)
        ]);
        //execute()は成功した場合trueを、失敗した場合falseを返すため、falseの場合例外処理へ
        if($res===false){
            throw new \MyApp\Exception\DuplicateUserName();
        }
    }
    public function login($values){
        //$valuesはLogin.phpから配列の形で$values['username'=>,'password'=>]として送られてくる
        $stmt=$this->db->prepare("select * from users where username=:username");
        $stmt->execute([
            ':username'=>$values['username']
        ]);
        //$stmtをオブジェクト化
        $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
        $user=$stmt->fetch();
        //もしformで入力されたユーザーが存在しない場合、パスワードが間違っている場合例外処理に移行
        if(empty($user) || !password_verify($values['password'],$user->password)){
            throw new \MyApp\Exception\UnmatchUserNameOrPassword();
        }
        //Login.phpにユーザー情報を返す
        return $user;
    }
    public function findAll(){
        //ユーザー一覧をDBからオブジェクト形式でひっぱる
        $stmt=$this->db->query("select * from users order by id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
        return $stmt->fetchAll();
    }
}