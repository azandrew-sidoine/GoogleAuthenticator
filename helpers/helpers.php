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

if (!function_exists('drewlabs_google_authenticator_hash_to_int')) {

    /**
     * @return int
     */
    function drewlabs_google_authenticator_hash_to_int(string $bytes, int $start)
    {
        return unpack('N', substr(substr($bytes, $start), 0, 4))[1];
    }
}

if (!function_exists('drewlabs_google_authenticator_secret')) {

    /**
     * Generates a random secret used for generating authenticator url.
     *
     * @param int $secretLength
     *
     * @return string
     */
    function drewlabs_google_authenticator_secret($secretLength)
    {
        return (new \Sonata\GoogleAuthenticator\FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true))
            ->encode(random_bytes($secretLength));
    }
}

if (!function_exists('drewlabs_google_authenticator_url')) {

    /**
     * Generate the authenticator app QR code URL.
     */
    function drewlabs_google_authenticator_url(
        string $user,
        string $hostname,
        string $secret,
        ?string $issuer = null,
        $qrSize = 200,
        $digits = 6,
        $period = 30,
        $alg = 'sha1'
    ) {
        $issuer = $issuer ?? null;
        $accountName = sprintf('%s@%s', $user, $hostname);
        // manually concat the issuer to avoid a change in URL
        $url = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($accountName, $secret, $issuer, $qrSize, $digits, $period, $alg);

        return $url;
    }
}


if (!function_exists('google_authenticator_resolve_alg')) {

    /**
     *  Resolve user provider algorithm by matching it against supported algorithms
     *
     * @param string $alg
     * @return \Closure
     */
    function google_authenticator_resolve_alg($initial = null)
    {
        return function ($alg) use ($initial) {
            return !is_null($alg) && in_array(strtoupper($alg), \Sonata\GoogleAuthenticator\GoogleAuthenticatorConstants::SUPPORTE_ALG) ?
                strtolower($alg) : $initial;
        };
    }
}
