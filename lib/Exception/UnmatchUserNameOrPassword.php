<?php

namespace MyApp\Exception;

class UnmatchUserNameOrPassword extends \Exception{
    protected $message='ユーザー名かパスワードに誤りがあります！';
}