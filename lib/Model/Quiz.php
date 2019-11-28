<?php
namespace MyApp\Model;

class QUiz extends \MyApp\Model{
    public function insertComment(){
        $keyArray=['comment','username','created'];
        $valueArray=["'a'","'atsuhiko'",'curdate()'];
        $this->insertData('comment',$keyArray,$valueArray);
    }
    public function getQuestionId(){
        $tableName='question';
        return $this->getData($tableName,'*','order by id desc');
    }
    public function saveAnswer(){
        for($i=1;$i<5;$i++){
            if($_POST['answer'.$i]!==''){
                if(intval($_POST['correctAnswer'])!==$i){
                    $Answers[]=[$_POST['answer'.$i],0];    
                }else{
                    $Answers[]=[$_POST['answer'.$i],1];    
                }
            }    
        }
        $keyArray=['username','questionid','a','correctAnswer'];
        foreach($Answers as $answer){
            $ValueArray=[$_SESSION['me']->username,intval($_POST['questionId']),$answer[0],$answer[1]];
            $this->insertData('answer',$keyArray,$ValueArray);
        }
    }
    public function saveQuestion(){
        $KeyArray=['username','q'];
        $ValueArray=[$_SESSION['me']->username,$_POST['question']];
        $this->insertData('question',$KeyArray,$ValueArray);
    }
}
