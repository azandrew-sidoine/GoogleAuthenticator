<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\GoogleAuthenticator\Exceptions;

class InvalidIssuerException extends \RuntimeException
{
    /**
     * Exception class instance initializer.
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
