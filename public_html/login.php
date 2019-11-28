<?php
//index.php同様config.phpの読み込み
require_once(__DIR__."/../config/config.php");
//\MyApp\Controller\Loginクラスをインスタンス化
$app=new \MyApp\Controller\Login();
//\MyApp\Controller\Loginクラス内で定義したrun()を実行->lob/Controller/Login.phpへ
$app->run();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザーログイン</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
    <div class="container">
        <h1>ユーザーログイン</h1>
        <!--submitされると$_SERVER['REQUEST_METHOD']='POST'になる-->
        <form action="" method="post">
            <!--submitされると$_POST[name]=valueが定義される
            ($i='条件' ? $a:$b) で条件がtrueの場合$i=$aに、falseの場合$i=$bに
            ここではパスワードが間違ったりした場合、入力したusernameは消えずに残るよう設定
            getValue()はController.php内に定義-->
            <input class="text-box" type="text" name="username" placeholder="ユーザー名(半角英数字)" value="<?=isset($app->getValue()->username) ? h($app->getValue()->username):'';?>"><br>
            <input class="text-box" type="password" name="password" placeholder="パスワード"><br>
            <!--getError()もController.php内に定義-->
            <p class="err"><?=h($app->getError('login'));?></p>
            <div class="btn-top">
                <input class="btn btn-sub" type="submit" value="ログイン">
            </div>
            <div class="btn-bottom">
                <input class="btn btn-res" type="reset" value="クリア">
            </div>
            <!--formがpostされる際$_POST['token']に＄_SESSION['token']を格納、$_SESSION['token']はController.php内の__construct()内で定義-->
            <input type="hidden" name='token' value="<?=h($_SESSION['token'])?>">
            </form>
            <a href="/register.php">新規登録はこちら</a>
    </div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" async></script>
<script async>
    
</script>
</body>
</html>