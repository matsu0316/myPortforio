<?php
//エラーを画面表示
ini_set("display_errors",1);
//データベースを操作するための定数を定義
define("DSN","mysql:dbhost=localhost;dbname=****");
define("DB_USER","*******");
define("DB_PASSWORD","********");
//functions.php内にてhtmlで文字を表示するためのエスケープ関数を定義
require_once(__DIR__."/../lib/functions.php");
//autoload.php内にてクラスが呼び出された際自動で必要なファイルを読み込む関数を定義
require_once(__DIR__."/autoload.php");

//session_start()で定義済み関数$_SESSIONが有効に->index.phpへ
session_start();

