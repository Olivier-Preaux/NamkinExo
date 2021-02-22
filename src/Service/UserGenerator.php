<?php

namespace App\Service;

use App\Entity\User;

class UserGenerator {

    public function createUser($data) 
    {
        $user = new User() ;
        $user->setFirstName($data["firstName"]);
        $user->setLastName($data["lastName"]);
        $user->setAddress($data["address"]);
        $user->setCity($data["city"]);

        return $user;
    }

    public function putUser( $data, $user)
    {
        $user->setFirstName($data["firstName"]);
        $user->setLastName($data["lastName"]);
        $user->setAddress($data["address"]);
        $user->setCity($data["city"]);

        return $user;
    }

    public function patchUser( $data, $user)
    {   if(isset($data["firstName"])){
        $user->setFirstName($data["firstName"]);}
        if(isset($data["lastName"])){
        $user->setLastName($data["lastName"]);}
        if(isset($data["address"])){
        $user->setAddress($data["address"]);}
        if(isset($data["city"])){
        $user->setCity($data["city"]);}

        return $user;
    }

}