<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PhoneNumber extends Constraint
{
    public string $message = 'Invalid phone number "{{ string }}".';
}
