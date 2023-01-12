<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Exception;
use Quinggu\OrderBundle\Client\CarrierApiClientInterface;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private PhoneNumberValidator $phoneNumberValidator;

    public function __construct(
        private readonly int $orderId,
        private readonly int $newStatus,
        private readonly CarrierApiClientInterface $apiClient,
        private readonly SmsApiClient $smsClient,
    ) {
        $this->phoneNumberValidator = new PhoneNumberValidator();
    }

    public function checkStatus()
    {
        /** @var OrderInterface $order */
        $order = $this->orderId; //getbyId

        $this->validateStatus();

        if($order->getStatus() != $this->newStatus){
//            $order->setStatus($this->newStatus);
            $carrierStatus = $this->apiClient->checkStatus($order->getStatus(), $this->newStatus)->getBody()->getContents();
            $this->notify($order, $carrierStatus);
        }

        return 'Status OK';
    }

    private function notify(OrderInterface $order, $carrierStatus)
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