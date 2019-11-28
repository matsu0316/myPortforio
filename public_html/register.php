<?php
require_once(__DIR__."/../config/config.php");
$app=new \MyApp\Controller\Register();
$app->run();
//var_dump($_SESSION['token']);
//var_dump($_POST['token']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規登録</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
    <div class="container">
        <h1>新規登録してコメントを投稿しよう</h1>
        <form action="" method="post">
            <input class="text-box" type="text" name="username" placeholder="ユーザー名(半角英数字)" value="<?=isset($app->getValue()->username) ? h($app->getValue()->username):'';?>"><br>
            <p class="err"><?=h($app->getError('username'));?></p>
            <input class="text-box" type="password" name="password" placeholder="パスワード"><br>
            <p class="err"><?=h($app->getError('password'));?></p>
            <div class="btn-top">
                <input class="btn btn-sub" type="submit" value="新規登録">
            </div>
            <div class="btn-bottom">
                <input class="btn btn-res" type="reset" value="クリア">
            </div>
            <input type="hidden" name='token' value="<?=h($_SESSION['token'])?>">
            </form>
            <a href="/login.php">ログインはこちら</a>
    </div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" async></script>
<script async>
    
</script>
</body>
</html>