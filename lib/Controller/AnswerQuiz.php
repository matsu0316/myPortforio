<?php
namespace MyApp\Controller;
class AnswerQuiz extends \MyApp\Controller{
    private $_answerQuiz;
    public function __construct(){
        $this->_answerQuiz=new \MyApp\Model\AnswerQuiz();
    }
    public function getQuiz(){
        $res=$this->_answerQuiz->getAllQuiz();
        if($res){
            return $res;
        }else{
            header("Location:http://".$_SERVER['HTTP_HOST'].'/quiz.php');
            exit;
        }
    }
}