<?php

namespace App\Service\Exception;

class InvalidToken extends \Exception
{
    protected $message = 'Invalid Token Arguments';
}