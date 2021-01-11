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

namespace Sonata\GoogleAuthenticator\Exceptions;

class InvalidSecretException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The secret name may not be an empty string.');
    }
}
