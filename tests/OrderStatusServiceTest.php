<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Quinggu\OrderBundle\Client\CarrierApiClient;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Repository\OrderRepository;
use Quinggu\OrderBundle\Service\OrderStatusService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderStatusServiceTest extends KernelTestCase
{
    //TODO: some tests

    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testCheckStatus(): void
    {
        $orderStatusService = new OrderStatusService(new CarrierApiClient(), new SmsApiClient(), $this->entityManager);
        $response = $orderStatusService->checkStatus(11, Order::STATUS_PREPARED);
        $this->assertSame(200, $response->getStatusCode());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}