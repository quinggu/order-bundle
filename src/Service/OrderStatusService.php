<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Exception;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

use function PHPUnit\Framework\throwException;

class OrderStatusService
{
    private PhoneNumberValidator $checkPhone;

    public function __construct(
        private readonly array $order = [],
        private readonly string $newStatus = ''
    ) {
        $this->checkPhone = new PhoneNumberValidator();
    }

    public function checkStatus()
    {
//        $order = $this->order;
        $order = $this->getTestOrder();
        $status = $order['status'];

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