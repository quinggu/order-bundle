<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Quinggu\OrderBundle\Client\CarrierApiClientInterface;
use Quinggu\OrderBundle\Client\SmsApiClientInterface;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private PhoneNumberValidator $phoneNumberValidator;

    public function __construct(
        private readonly CarrierApiClientInterface $apiClient,
        private readonly SmsApiClientInterface $smsClient,
        private readonly EntityManager $entityManager,
    ) {
        $this->phoneNumberValidator = new PhoneNumberValidator();
    }

    public function checkStatus(int $orderId, string $newStatus)
    {
        /** @var OrderInterface $order */
        $order = $this->entityManager->getRepository(OrderInterface::class)->findOneBy(['id' => $orderId]);

        $this->validateStatus($newStatus);

        if($order->getStatus() != $newStatus){
//            $order->setStatus($this->newStatus);
//            $this->entityManager->persist($order);
//            $this->entityManager->flush();
            $carrierStatus = $this->apiClient->checkStatus($order->getStatus(), $newStatus)->getBody()->getContents();
            $this->notify($order, $carrierStatus); // TODO: new service OrderNotifyService?
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

    protected function validateStatus($newStatus): void
    {
        if (!in_array($newStatus, Order::getStatusOptions(), true)) {
            throw new Exception(sprintf('Unknown status: %s', $newStatus));
        }
    }
}