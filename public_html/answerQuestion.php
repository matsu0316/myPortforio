<?php
ini_set('display_errors',1);
require_once(__DIR__.'/../config/config.php');
$answerQuiz=new \MyApp\Controller\AnswerQuiz();
$Quizes=$answerQuiz->getQuiz();
shuffle($Quizes);
var_dump($Quizes);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>問題を解く</title>
    <link rel="stylesheet" href="./../css/answerQuestion.css">
</head>
<body>
    <div class="quiz">
        <h1>第一問</h1>
        <h2><?=h($Quizes[0][0]->q);?></h2>
        <?php $n=1;?>
        <?php foreach($Quizes[0] as $quiz):?>
            <p>
                <input type='button' class="answer" value="a<?=$n;?>  <?=h($quiz->a);?>">
                <input type="hidden" class="checkCorrect" value="<?=h($quiz->correctAnswer);?>">
            </p>
            <?php $n+=1;?>
        <?php endforeach;?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $('.answer').on('click',function(){
                if($(this).siblings('.checkCorrect').val()==='1'){
                    $(this).addClass('correct');    
                }else{
                    $(this).addClass('wrong');
                }
            });
        });
    </script>
</body>
</html>