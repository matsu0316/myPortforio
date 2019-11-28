<?php

namespace MyApp\Model;

class Calender extends \MyApp\Model{
    public function setDBState(){
        $stmt=$this->db->prepare('select * from calender where username=:username and indexDay=:indexday');
        $stmt->execute([':indexday'=>$_POST['day'],':username'=>$_SESSION['me']->username]);  
        $res=$stmt->fetch(\PDO::FETCH_OBJ);
        if($res===false){
            $stmt=$this->db->prepare('insert into calender (username,state,indexDay) values (:username,1,:indexday)');
        }else{
            $stmt=$this->db->prepare('update calender set state=(state+1)%4 where username=:username and indexDay=:indexday');
        }
        //$resState=$stmt->fetchAll(\PDO::FETCH_OBJ);
        $stmt->execute([':username'=>$_SESSION['me']->username,':indexday'=>$_POST['day']]);
        $stmt=$this->db->prepare('select * from calender where username=:username and indexDay=:indexday');
        $stmt->execute([':indexday'=>$_POST['day'],':username'=>$_SESSION['me']->username]);
        $resState=$stmt->fetch(\PDO::FETCH_OBJ);
        return $resState->state;
    }
    public function getDBState(){
        $stmt=$this->db->prepare('select * from calender where username=:username and indexDay=:indexday');
        $stmt->execute([':indexday'=>$_SESSION['indexDay'],'username'=>$_SESSION['me']->username]);
        $getState=$stmt->fetch(\PDO::FETCH_OBJ);
        if($getState){
            return $getState->state;    
        }else{
            return null;
        }
    }

}