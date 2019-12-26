<?php

namespace App\Repository;

use App\Entity\TodoList;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class ListRepository extends EntityRepository
{
    public function findByIdAndUser(int $id, User $user): TodoList
    {
        $queryBuilder = $this->createQueryBuilder('l');
        $queryBuilder
            ->where('l.user = :user')
            ->setParameter('user', $user->getIdUser())
            ->andWhere('l.idList = :id')
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
