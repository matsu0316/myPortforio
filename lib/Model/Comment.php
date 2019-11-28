<?php
namespace MyApp\Model;

class Comment extends \MyApp\Model{
    //allComment()でデータベース内のコメントを引っ張る
    public function allComment(){
        $stmt=$this->db->prepare('select * from comment order by id desc LIMIT :count, 10');
        $stmt->bindValue(':count',$_SESSION['countComment']*10,\PDO::PARAM_INT);
        $stmt->execute();
        $comment=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $comment;
    }
    public function countComment(){
        $stmt=$this->db->query('select id from comment');
        $countCmt=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $countCmt;
    }
    public function post_comment(){
        //コメントが送られてきた場合データベースに投稿されたコメントを保存
        $stmt=$this->db->prepare('insert into comment (username,comment,created) values (:name,:comment,now())');
        $res=$stmt->execute([
            //$_SESSION['me']には自分のユーザー情報がオブジェクト形式で保管
            ':name'=>$_SESSION['me']->username,
            ':comment'=>$_POST['comment']
        ]);
        if($res==='false'){
            echo 'コメントの投稿に失敗しました';
            exit;
        }
    }
    public function delete(){
        //コメントを削除
        if(isset($_POST['res'])){
            $stmt=$this->db->prepare('delete from rescomment where id=:id');
            $stmt->execute([
                //comment-idを渡すことで削除したいコメントが何番のidのものか判断
                ':id'=>$_POST['comment-id']
            ]);
        }else{
            $stmt=$this->db->prepare('delete from comment where id=:id');
            $stmt->execute([
                //comment-idを渡すことで削除したいコメントが何番のidのものか判断
                ':id'=>$_POST['comment-id']
            ]);
            $stmt=$this->db->prepare('delete from rescomment where resid=:id');
            $res=$stmt->execute([
                //residを渡すことで削除したいコメントが何番のidのものか判断
                ':id'=>$_POST['comment-id']
            ]);    
        }
    //header('Location:http://'.$_SERVER['HTTP_HOST']);
    //exit;
    }
    public function postResponseComment(){
        try{
            $stmt=$this->db->prepare('insert into rescomment (username,comment,created,resid) values (:username,:comment,now(),:resid)');
            $stmt->execute([
                ':username'=>$_SESSION['me']->username,
                ':comment'=>$_POST['resComment'],
                ':resid'=>$_POST['resid']
            ]);    
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }
    public function getAllResponseComment(){
        $stmt=$this->db->query('select * from rescomment');
        $resComment=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $resComment;
    }
    public function setRating(){
        if($_POST['likeOrDislike']==='0'){
            $stmt=$this->db->prepare('insert into rating (commentid,username,posted) values(:commentid,:username,curdate())'); 
        }elseif($_POST['likeOrDislike']==='1'){
            $stmt=$this->db->prepare('insert into dislikeRating (commentid,username,posted) values(:commentid,:username,curdate())');
        }
        $stmt->bindValue(':commentid',$_POST['ratingId'],\PDO::PARAM_INT);
        $stmt->bindValue(':username',$_SESSION['me']->username,\PDO::PARAM_STR);
        $stmt->execute();
        return $this->getRating();
    }
    public function getRating(){
        if(isset($_POST['ratingId']) && $_POST['likeOrDislike']==='0'){
            $stmt=$this->db->prepare('select * from rating where commentid=:commentid');
            $stmt->bindValue(':commentid',$_POST['ratingId'],\PDO::PARAM_INT);
            $stmt->execute();    
        }elseif(isset($_POST['ratingId']) && $_POST['likeOrDislike']==='1'){
            $stmt=$this->db->prepare('select * from dislikeRating where commentid=:commentid');
            $stmt->bindValue(':commentid',$_POST['ratingId'],\PDO::PARAM_INT);
            $stmt->execute();
        }else{
            $stmt=$this->db->query('select * from rating');
        }
        $res=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $res;
    }
    public function getDislikeRating(){
        $stmt=$this->db->query('select * from dislikeRating');
        $res=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $res;
    }
    public function checkPostedLike(){
        $stmt=$this->db->prepare("select * from rating where username=:username and commentid=:id and posted=curdate()");
        $stmt->execute([
            ':username'=>$_SESSION['me']->username,
            ':id'=>$_POST['ratingId']
        ]);
        $res=$stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$res){
            $res=$this->checkPostedDislike();
        }
        return $res;
    }
    public function checkPostedDislike(){
        $stmt=$this->db->prepare("select * from dislikeRating where username=:username and commentid=:id and posted=curdate()");
        $stmt->execute([
            ':username'=>$_SESSION['me']->username,
            ':id'=>$_POST['ratingId']
        ]);
        $res=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
    public function deleteRating(){
        if($_POST['likeOrDislike']==='0'){
            $stmt=$this->db->prepare("delete from rating where commentid=:id and username=:username and posted=curdate()");
        }else{
            $stmt=$this->db->prepare("delete from dislikeRating where commentid=:id and username=:username and posted=curdate()");
        }
        $stmt->execute([
            ':id'=>$_POST['ratingId'],
            ':username'=>$_SESSION['me']->username
        ]);
        return $this->getRating();
    }
    public function checkDislike(){
        $stmt=$this->db->prepare("select * from dislikeRating where username=:username and commentid=:id and posted=curdate()");
        $stmt->execute([
            ':username'=>$_SESSION['me']->username,
            ':id'=>$_SESSION['ratingId']
        ]);
        $res=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
    public function checkLike(){
        $stmt=$this->db->prepare("select * from rating where username=:username and commentid=:id and posted=curdate()");
        $stmt->execute([
            ':username'=>$_SESSION['me']->username,
            ':id'=>$_SESSION['ratingId']
        ]);
        $res=$stmt->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
}