<?php

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;

class CarrierApiClient
{
    private const URL = 'http://api.carrier.pl/api/';

    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function checkStatus($currentStatus, $newStatus)
    {
        return $this->client->request('POST', self::URL, [$currentStatus, $newStatus]);
    }
}