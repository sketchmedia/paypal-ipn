<?php

namespace Sujip\PayPal\Notification\Http;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Psr\Http\Message\StreamInterface;

/**
 * Class Response.
 *
 * @package Sujip\PayPal\Notification\Http
 */
class Response extends Psr7Response
{
    /**
     * The guzzle http client response.
     *
     * @var \GuzzleHttp\Message\Response
     */
    protected $response;

    public function __construct(int $status = 200, array $headers = [], $body = null, string $version = '1.1', string $reason = null)
    {
        parent::__construct($status, $headers, $body, $version, $reason);
    }

    /**
     * @return mixed
     */
    public function isVerified()
    {
        return $this->getBody()->getContents() === Verifier::IPN_VERIFIED;
    }

    /**
     * @return mixed
     */
    public function isInvalid()
    {
        return $this->getBody()->getContents() === Verifier::IPN_INVALID;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->getStatusCode();
    }
}
