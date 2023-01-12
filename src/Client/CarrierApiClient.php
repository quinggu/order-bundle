<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class CarrierApiClient implements CarrierApiClientInterface
{
    private const URL = 'http://api.carrier.pl/api/';

    private Client $client;

    public function __construct(
    ) {
        $this->client = new Client();
    }

    public function checkStatus(string $currentStatus, string $newStatus): ResponseInterface
    {
        return $this->client->request('POST', self::URL, [$currentStatus, $newStatus]);
    }
}