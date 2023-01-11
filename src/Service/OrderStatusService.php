<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Service;

use Quinggu\OrderBundle\StatusDefaults;

class OrderStatusService
{
    private string $status;

    public function __construct(
        private readonly array $order = []
    ) {
        $this->status = StatusDefaults::X;
    }

    public function checkStatus()
    {
        $status = $this->status;
        $newStatus = $this->order['newStatus'];
        $sender = $this->order['sender'];
        $orderer = $this->order['orderer'];
        $recipient = $this->order['recipient'];

        if($status == $newStatus){
            return 'Status OK';
        }

        return $this->processChangeStatus();
    }

    private function processChangeStatus(): void
    {

    }
}