<?php

namespace Drewlabs\GoogleAuthenticator\Exceptions;

class InvalidAccountNameException extends \RuntimeException
{
    /**
     * Exception class instance initializer
     *
     * @param string $accountName
     */
    public function __construct($accountName)
    {
        $message = sprintf(
            'The account name may not contain a double colon (:) and may not be an empty string. Given "%s".',
            $accountName
        );
        parent::__construct($message);
    }
}
