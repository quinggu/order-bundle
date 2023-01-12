<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class SmsApiClient implements SmsApiClientInterface
{
    private const URL = 'http://api.sms.pl/api/';

    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function sendSms($message, array $phones): ResponseInterface
    {
        return $this->client->request('POST', self::URL, [$message, $phones]);
    }
}