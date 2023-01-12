<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Entity;

use Quinggu\OrderBundle\Model\UserInterface;
use Quinggu\OrderBundle\Validator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class User implements UserInterface
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\NotBlank]
    protected ?string $name = null;

    #[ORM\Column(name: 'phone', type: 'string', length: 64,)]
    #[Validator\PhoneNumber]
    protected ?string $phone = null;

    #[ORM\Column(name: 'address', type: 'string', length: 100)]
    #[Assert\NotBlank]
    protected ?string $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
}