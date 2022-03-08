<?php

namespace App\Security\Exception;

class InvalidToken extends \Exception
{
    protected $message = 'Invalid Token Arguments';
}