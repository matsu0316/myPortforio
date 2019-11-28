<?php

namespace MyApp\Exception;

class DuplicateUserName extends \Exception{
    protected $message='このユーザー名は既に使われています！';
}