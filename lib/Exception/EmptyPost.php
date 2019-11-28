<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception{
    protected $message='フォーム内が空です！';
}