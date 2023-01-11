<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class QuingguOrderBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
