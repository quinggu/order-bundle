<?php

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;

class SmsApiClient
{
    private const URL = 'http://api.sms.pl/api/';

    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function sendSms($message, $phones)
    {
        return $this->client->request('POST', self::URL, [$message, $phones]);
    }
}