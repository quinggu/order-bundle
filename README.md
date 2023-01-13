Quinggu Order Bundle
===================

## przykład użycia:

```php

use Quinggu\OrderBundle\Entity\Order;

public function __construct(
    private readonly OrderStatusService $orderStatus,
) {}

public function checkStatus()
{
    $this->orderStatus->checkStatus(1, Order::STATUS_PLACED);
}
}
```