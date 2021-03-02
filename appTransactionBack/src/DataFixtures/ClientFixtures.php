<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    public static function getReferenceClientKey($i) {
        return 'client' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 15; $i++) {
            $client = new Client();
            $client -> setNomComplet( $faker -> name)
                    -> setTelephone( $faker -> phoneNumber)
                    -> setNumCNI( $faker -> ean13);
            $this -> addReference( self::getReferenceClientKey($i), $client);
            $manager -> persist($client);
        }

        $manager->flush();
    }
}
