<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class SmsApiClient implements SmsApiClientInterface
{
    private const URL = 'http://api.sms.pl/api/';

    private Client $client;

    public function __construct(
    ) {
        $this->client = new Client();
    }

    public function sendSms($message, array $phones): ResponseInterface
    {
        return $this->client->request('POST', self::URL, [$message, $phones]);
    }
}