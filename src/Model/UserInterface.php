<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Model;

interface UserInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): self;

    public function getPhone(): ?string;

    public function setPhone(string $phone): self;

    public function getAddress(): string;

    public function setAddress(string $address): self;
}