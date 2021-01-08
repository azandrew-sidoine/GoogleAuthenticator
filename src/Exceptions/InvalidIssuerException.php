<?php

namespace Drewlabs\GoogleAuthenticator\Exceptions;

class InvalidIssuerException extends \RuntimeException
{
    /**
     * Exception class instance initializer
     *
     * @param string $issuer
     */
    public function __construct($issuer)
    {
        $message = sprintf(
            'The issuer name may not contain a double colon (:) and may not be an empty string. Given "%s".',
            $issuer
        );
        parent::__construct($message);
    }
}
