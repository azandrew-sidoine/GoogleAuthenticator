<?php

namespace Drewlabs\GoogleAuthenticator\Exceptions;

class InvalidSecretException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The secret name may not be an empty string.');
    }
}
