<?php
ini_set('display_errors',1);
require_once(__DIR__.'/../config/config.php');
$quiz=new \MyApp\Controller\Quiz();
$quiz->createQuiz();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>問題作成</title>
    <link rel="stylesheet" href="./../css/quiz.css">
</head>
<body>
    <div class="makeQuiz">
        <h1>問題作成</h1>
        <form action="" method='post'>
            <textarea class="makeQ" name="question" placeholder="問題文を入力してください"></textarea><br>
            <input type='hidden' name='questionId' value='<?=h($quiz->getId()+1);?>'>
            <select name="selectNum" id="selectNum">
                <option value="1">選択肢なし</option>
                <option value="2">2択</option>
                <option value="3">3択</option>
                <option value="4">4択</option>
            </select>
            <input type="button" id="selectButton" value="決定"><br>
            <p style='display:none' class="answer2 answer3 answer4" >正解の選択肢にチェックを入れてください</p>
            <input style='display:none' class="answer2 answer3 answer4" type="radio" name='correctAnswer' value='1'>
            <input style='display:none' name="answer1" class="answer1 answer2 answer3 answer4" type="text" placeholder="解答を入力してください"><br>
            <input style='display:none' class="answer2 answer3 answer4" type="radio" name='correctAnswer' value='2'>
            <input style='display:none' name="answer2" class="answer2 answer3 answer4" type="text" placeholder="解答を入力してください"><br>
            <input style='display:none' class="answer3 answer4" type="radio" name='correctAnswer' value='3'>
            <input style='display:none' name="answer3" class="answer3 answer4" type="text" placeholder="解答を入力してください"><br>
            <input style='display:none' class="answer4" type="radio" name='correctAnswer' value='4'>
            <input style='display:none' name="answer4" class="answer4" type="text" placeholder="解答を入力してください"><br>
            <input id="submit-btn" style='display:none' class="answer1 answer2 answer3 answer4" type="submit" value="保存">
        </form>
        <a href="./answerQuestion.php">問題を解く</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $('#selectButton').on('click',function(){
                $(`.answer4`).hide();
                let num=$('#selectNum').val();
                $(`.answer${num}`).show();
            });
            $('#submit-btn').on('click',function(){
                alert('保存しました');
            });
        });
    </script>
</body> 
</html>