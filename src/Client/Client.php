<?php

namespace Quinggu\OrderBundle\Client;

use GuzzleHttp\ClientInterface;

class Client
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {}

    public function checkStatus($currentStatus, $newStatus){

    }
}