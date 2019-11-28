<?php

namespace MyApp\Exception;

class InvalidUserName extends \Exception{
    protected $message='ユーザー名に不適切な文字が含まれています！';
}