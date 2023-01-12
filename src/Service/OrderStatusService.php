<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Exception;
use Quinggu\OrderBundle\Client\CarrierApiClient;
use Quinggu\OrderBundle\Client\SmsApiClient;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private const URL = 'http://api.xxx.pl/api/';
    private PhoneNumberValidator $checkPhone;

    public function __construct(
        private readonly int $orderId,
        private readonly int $newStatus,
        private readonly CarrierApiClient $apiClient,
        private readonly SmsApiClient $smsClient,
    ) {
        $this->checkPhone = new PhoneNumberValidator();
    }

    public function checkStatus()
    {
        /** @var OrderInterface $order */
        $order = $this->orderId; //getbyId
//        $order = $this->getTestOrder();
        $currentStatus = $order->getStatus();

        $this->validateStatus();

        if($currentStatus != $this->newStatus){
            $order->setStatus($this->newStatus);
            $this->notify($order);
        }

        return 'Status OK';
    }

    private function notify(OrderInterface $order): void
    {
        $status = $this->newStatus;
        $phones = $this->getPhones();
        $response = $this->apiClient->checkStatus('dsds', 'dsad');
        $response = $this->smsClient->sendSms('dsadas', []);
    }

    private function getPhones(): array
    {
        // $order = $this->order;
        $order = $this->getTestOrder();
        $senderPhone = $order['sender']['phone'];
        $ordererPhone = $order['orderer']['phone'];
        $recipientPhone = $order['recipient']['phone'];

        $this->checkPhone->validate($senderPhone, new PhoneNumber());
        $this->checkPhone->validate($ordererPhone, new PhoneNumber());
        $this->checkPhone->validate($recipientPhone, new PhoneNumber());

        return array_unique (array_merge ($senderPhone, $ordererPhone, $recipientPhone));
    }

    private function getTestOrder(): array
    {
        return [
            'status' => 'status',
            'sender' => [
                'name' => 'sender',
                'address' => 'Wawa',
                'phone' => '+48 333 333 333',
            ],
            'orderer' => [
                'name' => 'orderer',
                'address' => 'Wrocek',
                'phone' => '600-600-600',
            ],
            'recipient' => [
                'name' => 'recipient',
                'address' => 'Łódź',
                'phone' => '(+48)233233233',
            ],
        ];
    }

    protected function validateStatus(): void
    {
        if (!in_array($this->newStatus, Order::getStatusOptions(), true)) {
            throw new Exception(sprintf('Unknown status: %s', $this->newStatus));
        }
    }
}