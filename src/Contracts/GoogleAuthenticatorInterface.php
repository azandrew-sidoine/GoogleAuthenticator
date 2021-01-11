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

namespace Drewlabs\GoogleAuthenticator\Contracts;

interface GoogleAuthenticatorInterface
{
    /**
     * @param string $secret
     * @param string $code
     *
     * @return bool
     */
    public function checkCode($secret, $code, $discrepancy = 1);

    /**
     * @param string $secret
     *
     * @return string
     */
    public function getCode($secret, ?\DateTimeInterface $time = null);
}
