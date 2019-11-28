<?php
namespace MyApp\Controller;

class Quiz extends \MyApp\Controller{
    private $_quiz;
    public function __construct(){
        $this->_quiz=new \MyApp\Model\Quiz();
    }
    public function getId(){
        $id=$this->_quiz->getQuestionId();
        if($id){
            return intval($id->id);
        }else{
            return null;
        }
    }
    public function createQuiz(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->_quiz->saveQuestion();
            $this->_quiz->saveAnswer();
            header('Location:http://'.$_SERVER['HTTP_HOST'].'/quiz.php');
            exit;
        }
    }
}