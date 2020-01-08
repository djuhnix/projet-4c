<?php

namespace App\Repository;

use App\Entity\TodoList;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class ListRepository extends EntityRepository
{
    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findByUser(User $user): TodoList
    {
        $queryBuilder = $this->createQueryBuilder('l');
        $queryBuilder
            ->where('l.user = :user')
            ->setParameter('user', $user->getIdUser());

        return $queryBuilder->getQuery()->getSingleResult();
    }

    /**
     * @param User $user
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getListCountByUser(User $user): int
    {
        $queryBuilder = $this->createQueryBuilder('td');

        return $queryBuilder
            ->select('count(td.id)')
            ->where('td.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
