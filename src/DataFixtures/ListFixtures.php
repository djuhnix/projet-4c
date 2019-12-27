<?php

namespace App\DataFixtures;

use App\Entity\TodoList;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ListFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /* @var User $user */
        $user = $manager->getRepository(User::class)->find(3);

        $list = new TodoList();
        $list
            ->setListname('Market')
            ->setCreatedate(new\DateTime('now'))
            ->setDescription('List for shopping')
            ->setUser($user);

        $list2 = new TodoList();
        $list2
            ->setListname('Playing')
            ->setCreatedate(new\DateTime('now'))
            ->setDescription('Game to be play')
            ->setUser($user);

        $manager->persist($list);
        $manager->persist($list2);

        $manager->flush();
    }
}
