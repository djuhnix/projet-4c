<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $root = new User();
        $root->setEmail('def@def.com')
            ->setFirstname('Admin')
            ->setPassword($this->passwordEncoder->encodePassword(
                $root,
                'password'))
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $user = new User();
        $user->setEmail('user@def.com')
            ->setFirstname('User')
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'abc'))
            ->setRoles(['ROLE_USER']);

        $manager->persist($root);
        $manager->persist($user);

        $manager->flush();
    }
}
