<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Quinggu\OrderBundle\Entity\User;
use Quinggu\OrderBundle\Model\UserInterface;

/**
 * @method UserInterface|null find($id)
 * @method UserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInterface[] findAll()
 * @method UserInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
class UserRepository implements UserRepositoryInterface
{
    public function getClassName(): string
    {
        return User::class;
    }
}