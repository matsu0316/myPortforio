<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception{
    protected $message='パスワードに不適切な文字が含まれています！';
}