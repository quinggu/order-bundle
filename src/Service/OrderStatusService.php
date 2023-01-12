<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Doctrine\Persistence\ObjectManager;
use Quinggu\OrderBundle\Client\CarrierApiClientInterface;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Repository\OrderRepository;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private PhoneNumberValidator $phoneNumberValidator;

    private OrderRepository $orderRepository;

    public function __construct(
        private readonly int $orderId,
        private readonly string $newStatus,
        private readonly CarrierApiClientInterface $apiClient,
        private readonly SmsApiClient $smsClient,
//        private readonly ObjectManager $manager,
    ) {
        $this->phoneNumberValidator = new PhoneNumberValidator();
        $this->orderRepository = new OrderRepository();
    }

    public function checkStatus()
    {
        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneBy(['id' => $this->orderId]);

        $this->validateStatus();

        if($order->getStatus() != $this->newStatus){
//            $order->setStatus($this->newStatus);
//            $this->manager->persist($order);
//            $this->manager->flush();
            $carrierStatus = $this->apiClient->checkStatus($order->getStatus(), $this->newStatus)->getBody()->getContents();
            $this->notify($order, $carrierStatus);
        }

        return 'New status is same like current';
    }

    private function notify(OrderInterface $order, $carrierStatus): ResponseInterface
    {
        $phoneNumbers = $this->getPhoneNumbers($order);

        return $this->smsClient->sendSms($carrierStatus, $phoneNumbers);
    }

    private function getPhoneNumbers(OrderInterface $order): array
    {
        $this->phoneNumberValidator->validate($order->getSender()->getPhone(), new PhoneNumber());
        $this->phoneNumberValidator->validate($order->getOrderer()->getPhone(), new PhoneNumber());
        $this->phoneNumberValidator->validate($order->getRecipient()->getPhone(), new PhoneNumber());

        return array_unique([$order->getSender()->getPhone(), $order->getOrderer()->getPhone(), $order->getRecipient()->getPhone()]);
    }

    protected function validateStatus(): void
    {
        if (!in_array($this->newStatus, Order::getStatusOptions(), true)) {
            throw new Exception(sprintf('Unknown status: %s', $this->newStatus));
        }
    }
}