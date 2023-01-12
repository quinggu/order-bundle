<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Quinggu\OrderBundle\Entity\User;
use Quinggu\OrderBundle\Model\UserInterface;

/**
 * @method User getClassName()
 * @method UserInterface|null find($id)
 * @method UserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInterface[] findAll()
 * @method UserInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}