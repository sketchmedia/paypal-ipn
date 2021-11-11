<?php

namespace Sujip\PayPal\Notification\Http;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Sujip\PayPal\Notification\Contracts\Service;
use Sujip\PayPal\Notification\Exceptions\ServiceException;
use Sujip\PayPal\Notification\Payload;

/**
 * Class Request.
 *
 * @package Sujip\PayPal\Notification\Http
 */
class Request implements Service
{
    /**
     * The guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The service end-point.
     *
     * @var string
     */
    protected $url;

    /**
     * Create a new request instance.
     *
     * @param \GuzzleHttp\Client $client
     * @param $url
     */
    public function __construct(ClientInterface $client = null, $url = null)
    {
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * @param Payload $payload
     */
    public function call(Payload $payload)
    {
        $body = array_merge(
            ['cmd' => '_notify-validate'],
            $payload->all()
        );

        try {
            $response = $this->client->post(
                $this->url,
                ['form_params' => $body]
            );
        } catch (Exception $e) {
            throw new ServiceException($e->getMessage());
        }

        return new Response(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }
}
