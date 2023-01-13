<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Quinggu\OrderBundle\Client\CarrierApiClient;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Service\OrderStatusService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderStatusServiceTest extends KernelTestCase
{
    //TODO: some tests

    private ?EntityManager $entityManager;
    private ?CarrierApiClient $carrierApi;
    private ?SmsApiClient $smsApi;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->entityManager = $container->get('doctrine')->getManager();
        $this->carrierApi = $container->get(CarrierApiClient::class);
        $this->smsApi = $container->get(SmsApiClient::class);
    }

    public function testCheckStatus(): void
    {
        $orderStatusService = new OrderStatusService($this->carrierApi, $this->smsApi, $this->entityManager);
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