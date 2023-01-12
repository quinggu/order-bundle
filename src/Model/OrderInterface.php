<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Model;

interface OrderInterface
{
    public function getId(): ?int;

    public function getStatus(): string;

    public function setStatus(string $status): self;

    public function getSender(): ?UserInterface;

    public function setSender(?UserInterface $sender): self;

    public function getOrderer(): ?UserInterface;

    public function setOrderer(?UserInterface $orderer): self;

    public function getRecipient(): ?UserInterface;

    public function setRecipient(?UserInterface $recipient): self;
}