<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
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
interface OrderRepositoryInterface extends ObjectRepository
{
}