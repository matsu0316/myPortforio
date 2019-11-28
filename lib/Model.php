<?php

namespace MyApp;

class Model{
    protected $db;
    public function __construct(){
        try{
            //PDOでデータベースに接続、引数はconfig.phpで設定した定数
            //DSN='mysql:dbhost=localhost;dbname=myportforio'
            //$dbはオブジェクト
            $this->db=new \PDO(DSN,DB_USER,DB_PASSWORD);    
        }catch(\PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }
    //テーブルのデータを取得＊カラム指定可
    protected function getAllData($table,$column='*',$condition=''){
        $stmt=$this->db->query('select '.$column.' from '.$table.' '.$condition);
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
    protected function getData($table,$column='*',$condition=''){
        $stmt=$this->db->query('select '.$column.' from '.$table.' '.$condition);
        $data=$stmt->fetch(\PDO::FETCH_OBJ);
        return $data;
    }
    
    //テーブルにレコードを挿入＊$keyArrayと$valueArrayは配列
    protected function insertData($table,$keyArray,$valueArray){
        foreach($valueArray as $value){
            if(gettype($value)==='string'){
                $vl[]="'".$value."'";
            }else{
                $vl[]=$value;
            }
        }
        if(count($keyArray)===count($valueArray)){
            $keys=implode(',',$keyArray);
            $values=implode(',',$vl);
            $stmt=$this->db->query("insert into ".$table." (".$keys.") values (".$values.")");
        }
    }
}
