<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Quinggu\OrderBundle\Entity\Order;
use Quinggu\OrderBundle\Model\OrderInterface;

/**
 * @method Order getClassName()
 * @method OrderInterface|null find($id)
 * @method OrderInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderInterface[] findAll()
 * @method OrderInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }
}