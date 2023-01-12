<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;

/**
 * @method OrderInterface|null find($id)
 * @method OrderInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderInterface[] findAll()
 * @method OrderInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
class OrderRepository implements OrderRepositoryInterface
{
    public function getClassName(): string
    {
        return Order::class;
    }
}