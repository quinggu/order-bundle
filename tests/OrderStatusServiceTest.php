<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Quinggu\OrderBundle\Client\CarrierApiClient;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Repository\OrderRepository;
use Quinggu\OrderBundle\Service\OrderStatusService;

class OrderStatusServiceTest extends TestCase
{
    //TODO: some tests

    public function testCheckStatus(): void
    {
        $orderStatusService = new OrderStatusService(new CarrierApiClient(), new SmsApiClient(), new OrderRepository());
        $response = $orderStatusService->checkStatus();
        $this->assertSame(200, $response->getStatusCode());
    }
}