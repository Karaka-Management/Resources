<?php declare(strict_types=1);

namespace Stripe\Exception\OAuth;

/**
 * Implements properties and methods common to all (non-SPL) Stripe OAuth
 * exceptions.
 */
abstract class OAuthErrorException extends \Stripe\Exception\ApiErrorException
{
    protected function constructErrorObject()
    {
        if ($this->jsonBody === null) {
            return null;
        }

        return \Stripe\OAuthErrorObject::constructFrom($this->jsonBody);
    }
}
