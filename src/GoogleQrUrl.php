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

namespace Sonata\GoogleAuthenticator;

/**
 * Responsible for QR image url generation.
 *
 * @see http://goqr.me/api/
 * @see http://goqr.me/api/doc/
 * @see https://github.com/google/google-authenticator/wiki/Key-Uri-Format
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class GoogleQrUrl
{
    /**
     * Private by design.
     */
    private function __construct()
    {
    }

    /**
     * Generates a URL that is used to show a QR code.
     *
     * Account names may not contain a double colon (:). Valid account name
     * examples:
     *  - "John.Doe@gmail.com"
     *  - "John Doe"
     *  - "John_Doe_976"
     *
     * The Issuer may not contain a double colon (:). The issuer is recommended
     * to pass along. If used, it will also be appended before the accountName.
     *
     * The previous examples with the issuer "Acme inc" would result in label:
     *  - "Acme inc:John.Doe@gmail.com"
     *  - "Acme inc:John Doe"
     *  - "Acme inc:John_Doe_976"
     *
     * The contents of the label, issuer and secret will be encoded to generate
     * a valid URL.
     *
     * @param string      $accountName The account name to show and identify
     * @param string      $secret      The secret is the generated secret unique to that user
     * @param string|null $issuer      Where you log in to
     * @param int         $size        Image size in pixels, 200 will make it 200x200
     * @param int $digits
     * @param int $period
     * @param string $alg
     *
     * @return string
     */
    public static function generate(
        string $accountName,
        string $secret,
        ?string $issuer = null,
        int $size = 200,
        $digits = 6,
        $period = 30,
        $alg = 'sha1'
    ) {
        if ('' === $accountName || false !== strpos($accountName, ':')) {
            throw new \Sonata\GoogleAuthenticator\Exceptions\InvalidAccountNameException($accountName);
        }

        if ('' === $secret) {
            throw new \Sonata\GoogleAuthenticator\Exceptions\InvalidSecretException();
        }

        $label = $accountName;
        $otpauthString = 'otpauth://totp/%s?secret=%s';

        if (null !== $issuer) {
            if ('' === $issuer || false !== strpos($issuer, ':')) {
                throw new \Sonata\GoogleAuthenticator\Exceptions\InvalidIssuerException($issuer);
            }

            // use both the issuer parameter and label prefix as recommended by Google for BC reasons
            $label = $issuer . ':' . $label;
            $otpauthString .= '&issuer=%s';
        }
        $otpauthString = sprintf($otpauthString, $label, $secret, $issuer);
        if (isset($alg) && is_string($alg)) {
            $otpauthString = \sprintf('%s&algorithm=%s', $otpauthString, strtoupper(google_authenticator_resolve_alg('sha1')($alg)));
        }

        if (isset($digits) && is_integer($digits)) {
            $otpauthString = \sprintf('%s&digits=%d', $otpauthString, $digits);
        }

        if (isset($period) && is_integer($period)) {
            $otpauthString = \sprintf('%s&period=%d', $otpauthString, $period);
        }

        $otpauthString = rawurlencode($otpauthString);

        return sprintf(
            'https://api.qrserver.com/v1/create-qr-code/?size=%1$dx%1$d&data=%2$s&ecc=M',
            $size,
            $otpauthString
        );
    }
}
