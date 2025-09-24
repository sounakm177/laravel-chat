<?php

namespace App\Exceptions;

use Exception;

class MessageDeliveryException extends Exception
{
    protected $message = 'There was an issue delivering the message.';

    public function __construct($message = null)
    {
        if ($message) {
            $this->message = $message;
        }
        parent::__construct($this->message);
    }
}