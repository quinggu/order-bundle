<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Client;

use Psr\Http\Message\ResponseInterface;

interface SmsApiClientInterface
{
    public function sendSms($message, array $phones): ResponseInterface;
}