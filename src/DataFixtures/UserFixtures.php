<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setEmail('user@paygreen.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test1234'
        ));

        $admin = new User;
        $admin->setEmail('admin@paygreen.fr')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'test1234'
        ));

        $manager->persist($user);
        $manager->persist($admin);

        $manager->flush();
    }
}
