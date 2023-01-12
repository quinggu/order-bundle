<?php

namespace Quinggu\OrderBundle\Client;

use Psr\Http\Message\ResponseInterface;

interface CarrierApiClientInterface
{
    public function checkStatus(string $currentStatus, string $newStatus): ResponseInterface;
}