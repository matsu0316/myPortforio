<?php
//config.phpが読み込まれる
require_once(__DIR__."/../config/config.php");
//名前空間\MyApp\ControllerのIndexクラスをインスタンス化
//またController.php内の__construct()で$_SESSION['token']を定義し32文字のランダムな文字列を格納
$app=new MyApp\Controller\Index();
//名前空間\MyApp\ControllerのIndexクラス内で定義したrun()を呼び出し->lib/Controller/Index.phpへ
$app->run();
$comment=new MyApp\Controller\Comment();
//var_dump($comment->getResponseComment());
//exit;
//var_dump($comment->commentNum());
//exit;
//exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="/css/index.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header-left">
            <p>ログイン中のユーザー：<?=h($_SESSION['me']->username);?></p>
        </div>
        <div class="header-right">
            <form action="logout.php" method="post">
                <input class="logout" type="submit" value="ログアウト">
                <input type="hidden" name='token' value="<?=h($_SESSION['token'])?>">
            </form>
        </div>
    </header>
    <div class="main">
        <div class="container-all">
            <div class="container-left">
                <p>ユーザー一覧</p>
                <ul>
                    <?php foreach($app->getValue()->users as $user) :?>
                    <li>〇<?=h($user->username);?></li>
                    <?php endforeach;?>
                </ul>
            </div>    
            <div class="container-main">
                <h2>掲示板</h2>
                <form action="post_comment.php" method="post">
                    <input type="hidden" name='token' value="<?=h($_SESSION['token'])?>">
                    <p><textarea name="comment"></textarea></p>
                    <input class="bttn btn-sub" type="submit" value='送信'>
                    <input class="bttn btn-reset" type="reset" value="リセット">
                </form>
                <div class="comments">
                    <?php foreach($comment->getComment() as $cmt) :?>
                        <hr>
                        <div class="comment-dis">
                            <div class='comment-user'>
                                <?=h($cmt->id).'.　'.h($cmt->username) . '　　　'.h($cmt->created);?>
                                <div class="dropdown">
                                    <button type="button" aria-expanded="false" id="dropdownMenuButton" data-toggle="dropdown" class="dropbtn dropdown-toggle">
                                    </button>    
                                    <ul  class="dropdown-menu res-btn" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item">返信</li>
                                        <?php if($cmt->username===$_SESSION['me']->username):?>
                                            <li class="dropdown-item">
                                            <form action="delete.php" method="post">
                                                <input type="submit" value="削除">
                                                <input type="hidden" value="<?=h($cmt->id);?>" name="comment-id">
                                            </form>
                                        </li>
                                        <?php endif;?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row commentSection">
                                <div class="col-8">
                                    <?=h($cmt->comment);?>
                                </div>
                                <div class="col-4">
                                    <i id='dislike' class="<?=h($comment->checkLikeOrDislike($cmt->id)==='dislike') ? 'postedDislike': '';?> fas fa-thumbs-down">
                                        <input type="hidden" id='selectDislike' value="1">
                                        <?php if(isset($comment->getdisLikeRate()[$cmt->id])):?>
                                            <?=h($comment->getdisLikeRate()[$cmt->id]);?>
                                        <?php endif;?>
                                    </i>
                                    <input type="hidden" id='ratingId' value="<?=h($cmt->id);?>">
                                    <i id='like' class="<?=h($comment->checkLikeOrDislike($cmt->id)==='like') ? 'postedLike': '';?> fas fa-thumbs-up">
                                        <input type="hidden" id='selectLike' value="0">
                                        <?php if(isset($comment->getLikeRate()[$cmt->id])):?>
                                            <?=h($comment->getLikeRate()[$cmt->id]);?>
                                        <?php endif;?>
                                    </i>
                                </div>
                            </div>
                            <form  style='display:none;' id='resCom' action="postResponse.php" method='post'>
                                <input type="hidden" name="resid" value="<?=h($cmt->id)?>">
                                <textarea class="tarea" name="resComment" id="tarea">>><?=h($cmt->id);?> </textarea><br>
                                <input type="submit" value="送信">
                            </form>
                            <?php foreach($comment->getResponseComment() as $res):?>
                                <?php if($res->resid===$cmt->id):?>
                                    <p><?=h($res->username).'　　　'.h($res->created);?></p>
                                    <p class="response-comment"><?=h($res->comment);?></p>
                                    <?php if($res->username===$_SESSION['me']->username):?>
                                        <form action="delete.php" method="post">
                                            <input class="bttn res-del" type="submit" value="削除">
                                            <input type="hidden" value="<?=h($res->id);?>" name="comment-id">
                                            <input type="hidden" value="1" name="res">
                                        </form>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>                    
                    <?php endforeach;?>
                    <hr>
                    <form class="move-btn next-btn" action="next.php" method="post">
                        <input type="submit" value="次の10件">
                    </form>
                    <form class="move-btn prev-btn" action="prev.php" method="post">
                        <input type="submit" value="前の10件">
                        <input type="hidden" name="maxComment" value="<?=h($comment->commentNum());?>">
                    </form>
                    <a href="test.php">テストへ</a>
                    <p><a href="quiz.php">問題作成へ</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $(function(){
            "use strict";
            $('.res-btn').on('click',function(){
                if($(this).hasClass('response')){
                    $(this).parent().parent().siblings('#resCom').fadeOut(800);
                    $(this).removeClass('response');
                }else{
                    $(this).parent().parent().siblings('#resCom').fadeIn(1000);
                    $(this).addClass("response");
                }
            });
        });
        $('i').on('click',function(){
            let ratingButton=this;
            let selectVal=$(this).children().val();
            $.post('_isPosted.php',{
                ratingId:$(this).siblings('#ratingId').val()
            },function(isPosted){
                if(!isPosted){
                    console.log(isPosted);
                    $.post('_postRate.php',{
                        likeOrDislike:selectVal,
                        ratingId:$(ratingButton).siblings('#ratingId').val()
                    },function(res){
                        $(ratingButton).html("<input type='hidden' id='selectLike' value='"+selectVal+"'>"+res);
                        if(selectVal==='1'){
                            $(ratingButton).css({'color':'#db5858'});
                        }else if(selectVal==='0'){
                            $(ratingButton).css({'color':'#399dc2'});
                        }
                    });            
                }else{
                    $.post('_changeRating.php',{
                        likeOrDislike:selectVal,
                        ratingId:$(ratingButton).siblings('#ratingId').val()
                    },function(res){
                        console.log(res);
                        if(res.bool){
                            if(selectVal==='1'){
                                $(ratingButton).siblings('#like').html("<input type='hidden' id='selectLike' value='0'> "+res.like).css({'color':'rgb(110, 106, 106)'});
                                $(ratingButton).html("<input type='hidden' id='selectLike' value='1'> "+res.dislike).css({'color':'#db5858'});
                            }else{
                                $(ratingButton).html("<input type='hidden' id='selectLike' value='0'> "+res.like).css({'color':'rgb(110, 106, 106)'});
                            }
                        }else{
                            if(selectVal==='0'){
                                $(ratingButton).siblings('#dislike').html("<input type='hidden' id='selectDislike' value='1'> "+res.dislike).css({'color':'rgb(110, 106, 106)'});
                                $(ratingButton).html("<input type='hidden' id='selectLike' value='0'> "+res.like).css({'color':'#399dc2'});
                            }else{
                                $(ratingButton).html("<input type='hidden' id='selectDislike' value='1'> "+res.dislike).css({'color':'rgb(110, 106, 106)'});
                            }
                        }
                    });
                }                
            })
        });
    </script>
</body>
</html>