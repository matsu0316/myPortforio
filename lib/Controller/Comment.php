<?php
namespace MyApp\Controller;

class Comment extends \MyApp\Controller{
    private $_num=0;
    private $_cmt;
    public function __construct(){
        $this->_cmt=new \MyApp\Model\Comment();
    }
    public function getComment(){
        //$commentsをオブジェクト形式で返す
        return $this->_cmt->allComment();
    }
    public function delComment(){
        //データベース処理は名前空間Modelで行うためそちらを呼び出す
        $this->_cmt->delete();
        //header('Location:http://'.$_SERVER['HTTP_HOST']);
        //exit;
    }
    public function postResponse(){
        $this->_cmt->postResponseComment();
    }
    public function getResponseComment(){
        return $this->_cmt->getAllResponseComment();
    }
    public function commentNum(){
        $num=intval(count($this->_cmt->countComment())/10);
        return($num);
    }
    public function postRating(){
        if(!isset($_POST['ratingId'])){
            throw new \Exception('Error');
        }elseif($this->_validate()){
            echo('不正な入力がありました');
            exit;
        }
        return count($this->_cmt->setRating());
    }
    private function _validate(){
        return false;
    }
    public function getLikeRate(){
        $setArr=[];
        $rateArr=$this->_cmt->getRating();
        foreach($rateArr as $rate){
            if(!isset($setArr[$rate->commentid])){
                $setArr[$rate->commentid]=1;
            }else{
                $setArr[$rate->commentid]+=1;    
            }
        }
        return $setArr;
    }
    public function getdisLikeRate(){
        $setArr=[];
        $rateArr=$this->_cmt->getDislikeRating();
        foreach($rateArr as $rate){
            if(!isset($setArr[$rate->commentid])){
                $setArr[$rate->commentid]=1;
            }else{
                $setArr[$rate->commentid]+=1;    
            }
        }
        return $setArr;
    } 
    public function isPostedRating(){
        return $this->_cmt->checkPostedLike();
    }
    public function changePosted(){

        $res=$this->_cmt->checkPostedDislike();
        //$add=0
        if($res){
            if($_POST['likeOrDislike']==='0'){
                //バッドボタンがすでに押されてるときにグッドボタンを押したときはここの処理
                $add=count($this->_cmt->setRating());
                $_POST['likeOrDislike']='1';
            }else{
                $_POST['likeOrDislike']='0';
                $add=count($this->_cmt->getRating());
                $_POST['likeOrDislike']='1';
            }
            $delete=count($this->_cmt->deleteRating());
            $checkPosted=[
                'bool'=>false,
                'like'=>$add,
                'dislike'=>$delete
            ];
        }else{
            if($_POST['likeOrDislike']==='1'){
                $add=count($this->_cmt->setRating());
                $_POST['likeOrDislike']='0';
            }else{
                $_POST['likeOrDislike']='1';
                $add=count($this->_cmt->getRating());
                $_POST['likeOrDislike']='0';
            }
            $delete=count($this->_cmt->deleteRating());
            $checkPosted=[
                'bool'=>true,
                'like'=>$delete,
                'dislike'=>$add
            ];
        }
        return $checkPosted;
    }
    public function checkLikeOrDislike($id){
        $_SESSION['ratingId']=$id;
        if($this->_cmt->checkLike()){
            return('like');
        }elseif($this->_cmt->checkDislike()){
            return('dislike');
        }
    }
}