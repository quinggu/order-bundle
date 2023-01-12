<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Service\OrderStatusService;

class OrderStatusServiceTest extends TestCase
{
    //TODO: some tests

    public function testCheckStatus(): void
    {
        $orderStatusService = new OrderStatusService(11, Order::STATUS_PREPARED);
        $response = $orderStatusService->checkStatus();
        $this->assertSame(200, $response->getStatusCode());
    }
}