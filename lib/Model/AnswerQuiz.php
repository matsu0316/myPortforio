<?php
namespace MyApp\Model;
class AnswerQuiz extends \MyApp\Model{
    public function getAllQuiz(){
        for($i=1;$i<intval($this->getData('question','*','order by id desc')->id)+1;$i++){
            $res=$this->getAllData('question','*','join answer on question.id=questionid where questionid='.$i.' and question.username="atsuhiko"');
            if(isset($res[1])){
                $Quizes[]=$res;
            }    
        }
        return $Quizes;
    }
}