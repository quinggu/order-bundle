<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Entity;

use Quinggu\OrderBundle\Model\OrderInterface;
use Quinggu\OrderBundle\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Quinggu\OrderBundle\Repository\OrderRepositoryInterface;

#[ORM\Entity(repositoryClass: OrderRepositoryInterface::class)]
class Order implements OrderInterface
{
    public const STATUS_NONE = 'NONE';
    public const STATUS_PLACED = 'PLACED';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_PREPARED = 'PREPARED';
    public const STATUS_IN_DELIVERY = 'IN_DELIVERY';

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(name: 'status', type: 'string')]
    protected string $status = self::STATUS_NONE;

    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    protected ?UserInterface $sender = null;

    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    protected ?UserInterface $orderer = null;

    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    protected ?UserInterface $recipient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSender(): ?UserInterface
    {
        return $this->sender;
    }

    public function setSender(?UserInterface $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getOrderer(): ?UserInterface
    {
        return $this->orderer;
    }

    public function setOrderer(?UserInterface $orderer): self
    {
        $this->orderer = $orderer;

        return $this;
    }

    public function getRecipient(): ?UserInterface
    {
        return $this->recipient;
    }

    public function setRecipient(?UserInterface $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public static function getStatusOptions(): array
    {
        return [
            'Not selected' => self::STATUS_NONE,
            'Placed' => self::STATUS_PLACED,
            'In progress' => self::STATUS_IN_PROGRESS,
            'Prepared' => self::STATUS_PREPARED,
            'In delivery' => self::STATUS_IN_DELIVERY
        ];
    }
}