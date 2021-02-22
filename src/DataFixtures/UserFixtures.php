<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    const USERS = [
        'Durand' => [
            'firstName' =>  'Jean',
            'address'   =>  '5 rue de l\'allée',
            'city'      =>  'Troyes'
        ],
        'Dupont' => [
            'firstName' =>  'Bernard',
            'address'   =>  '1 rue du Grand Chemin',
            'city'      =>  'Reims'
        ],
        'Martin' => [
            'firstName' =>  'Pierre',
            'address'   =>  '3 rue de la Tour',
            'city'      =>  'Paris'
        ],
        'Legrand' => [
            'firstName' =>  'Louis',
            'address'   =>  '10 rue du Parc',
            'city'      =>  'Lyon'
        ],
        'Lepetit' => [
            'firstName' =>  'Jules',
            'address'   =>  '5 boulevard Danton',
            'city'      =>  'Lille'
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $userLastName => [ 'firstName' => $userFirstName , 'address' => $userAdress , 'city' => $userCity]){

            $user= new User();
            $user->setLastName($userLastName);
            $user->setFirstName($userFirstName);
            $user->setAddress($userAdress);
            $user->setCity($userCity);

            $manager->persist($user);


        // $product = new Product();
        // $manager->persist($product);
        }

        $manager->flush();
    }
}
