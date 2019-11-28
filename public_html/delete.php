<?php
require_once(__DIR__.'/../config/config.php');
//index.phpからデータが送られてきた場合Controller内のCommentクラスを呼び出す
if(isset($_POST['comment-id'])){
    $delCom=new \MyApp\Controller\Comment();
    //Commentクラス内のdelComment()を呼び出しコメントを削除
    $delCom->delComment();
}
//終了した場合index.phpへリダイレクトし、コメントが削除された状態をページに反映し、$_POSTをリセット
header('Location:http://'.$_SERVER['HTTP_HOST']);