<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager  ): void
    {
        $user= new User();
        $user->setEmail('mail@email.com');
        $user->setUsername('Benjamin');
        $user->setTel('0699464547');

        $user->setPassword($this->passwordHasher->hashPassword($user,'123'));

        $manager->persist($user);
        $manager->flush();
    }
}
