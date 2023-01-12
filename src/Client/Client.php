<?php

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;

class Client
{
    private const URL = 'http://api.xxx.pl/api/';

    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function checkStatus($currentStatus, $newStatus){
        $this->client->request('POST', self::URL, []);
    }
}