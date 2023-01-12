<?php

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class CarrierApiClient implements CarrierApiClientInterface
{
    private const URL = 'http://api.carrier.pl/api/';

    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function checkStatus($currentStatus, $newStatus): ResponseInterface
    {
        return $this->client->request('POST', self::URL, [$currentStatus, $newStatus]);
    }
}