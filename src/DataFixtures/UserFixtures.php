<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->dataProvider() as [$email, $roles, $password]) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setPassword($password);

            $manager->persist($user);
        }
        $manager->flush();
    }


    public function dataProvider()
    {
        yield ['email@email1.test', ['ROLES_ADMIN'], 'email@email1.test'];
        yield ['email@email2.test', ['ROLES_ADMIN'], 'email@email2.test'];
        yield ['email@email3.test', ['ROLES_ADMIN'], 'email@email3.test'];
        yield ['email@email4.test', ['ROLES_ADMIN'], 'email@email4.test'];
        yield ['email@email5.test', ['ROLES_ADMIN'], 'email@email5.test'];
        yield ['email@email6.test', ['ROLES_ADMIN'], 'email@email6.test'];
        yield ['email@email7.test', ['ROLES_ADMIN'], 'email@email7.test'];
        yield ['email@email8.test', ['ROLES_ADMIN'], 'email@email8.test'];
        yield ['email@email9.test', ['ROLES_ADMIN'], 'email@email9.test'];
        yield ['email@email10.test', ['ROLES_ADMIN'], 'email@email10.test'];
        yield ['email@email11.test', ['ROLES_ADMIN'], 'email@email11.test'];
        yield ['email@email12.test', ['ROLES_ADMIN'], 'email@email12.test'];
    }
}
