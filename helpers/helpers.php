<?php


if (!function_exists('drewlabs_google_authenticator_hash_to_int')) {

    /**
     *
     * @param string $bytes
     * @param integer $start
     * @return int
     */
    function drewlabs_google_authenticator_hash_to_int(string $bytes, int $start)
    {
        return unpack('N', substr(substr($bytes, $start), 0, 4))[1];
    }
}

if (!function_exists('drewlabs_google_authenticator_secret')) {

    /**
     * Generates a random secret used for generating authenticator url
     *
     * @param int $secretLength
     * @return string
     */
    function drewlabs_google_authenticator_secret($secretLength)
    {
        return (new \Drewlabs\GoogleAuthenticator\FixedBitNotation(5, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', true, true))
            ->encode(random_bytes($secretLength));
    }
}

if (!function_exists('drewlabs_google_authenticator_url')) {

    /**
     * Generate the authenticator app QR code URL
     *
     * @param string $user
     * @param string $hostname
     * @param string $secret
     * @param string|null $issuer
     */
    function drewlabs_google_authenticator_url(string $user, string $hostname, string $secret, ?string $issuer = null)
    {
        $issuer = $issuer ?? null;
        $accountName = sprintf('%s@%s', $user, $hostname);
        // manually concat the issuer to avoid a change in URL
        $url = \Drewlabs\GoogleAuthenticator\GoogleQrUrl::generate($accountName, $secret);

        if ($issuer) {
            $url .= '%26issuer%3D'.$issuer;
        }
        return $url;
    }
}
