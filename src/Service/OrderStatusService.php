<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Quinggu\OrderBundle\StatusDefaults;
use Quinggu\OrderBundle\Validator\PhoneNumber;
use Quinggu\OrderBundle\Validator\PhoneNumberValidator;

class OrderStatusService
{
    private string $status;

    private PhoneNumberValidator $checkPhone;

    public function __construct(
        private readonly array $order = []
    ) {
        $this->status = StatusDefaults::X;
        $this->checkPhone = new PhoneNumberValidator();
    }

    public function checkStatus()
    {
        $status = $this->status;
        $newStatus = $this->order['newStatus'];

        if($status == $newStatus){
            return 'Status OK';
        }

        return $this->processChangeStatus();
    }

    private function processChangeStatus(): void
    {


        $phones = $this->getPhones();
    }

    private function getPhones()
    {
        $senderPhone = $this->order['sender']['phone'];
        $ordererPhone = $this->order['orderer']['phone'];
        $recipientPhone = $this->order['recipient']['phone'];

        $this->checkPhone->validate($senderPhone, new PhoneNumber());

        $phones = array_unique (array_merge ($senderPhone, $ordererPhone, $recipientPhone));

    }
}