<?php
namespace MyApp\Controller;

class Calender extends \MyApp\Controller{
    private $_modelCalender;
    public function __construct(){
        $this->_modelCalender=new \MyApp\Model\Calender();
    }
    public function setState(){
        $res=$this->_modelCalender->setDBState();
        return $res;
    }
    public function getScheduledState(){
        return $this->_modelCalender->getDBState();
    }

}