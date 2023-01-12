<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Exception;
use GuzzleHttp\ClientInterface;
use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private const URL = 'http://api.xxx.pl/api/';
    private PhoneNumberValidator $checkPhone;

    public function __construct(
        private readonly int $orderId,
        private readonly string $newStatus = '',
        private readonly ClientInterface $client,

    ) {
        $this->checkPhone = new PhoneNumberValidator();
    }

    public function checkStatus()
    {
        /** @var OrderInterface $order */
        $order = $this->orderId; //getbyId
//        $order = $this->getTestOrder();
        $status = $order->getStatus();

        if(!in_array($this->newStatus, Order::getStatusOptions(), true)){
            throw new Exception(sprintf('Unknown status: %s', $this->newStatus));
        }

        if($status == $this->newStatus){
            return 'Status OK';
        }

        $this->processChangeStatus();

        return '';
    }

    private function processChangeStatus(): void
    {
        $status = $this->newStatus;
        $phones = $this->getPhones();
        //poinformować serwis "Z" za pomocą API (REST / SOAP) o konieczności wysłania powiadomień na konkretne numery telefonów (niepowtarzające się).
        $response = $this->client->request(
            'GET',
            self::URL,
            [
                'data' => [
                    'status' => $status,
                    'phones' => $phones
                ]
            ]
        );
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
}