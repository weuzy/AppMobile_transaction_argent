<?php

namespace App\DataFixtures;

use App\Entity\CompteDeTransaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompteFixtures extends Fixture
{
    public static function getReferenceKey($i) {
        return sprintf('compte_%s', $i);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i =1; $i <= 5; $i++) {
            $compte = new CompteDeTransaction();
            $compte -> setNumeroCompte( $faker -> bankAccountNumber )
                    -> setSolde(700000 )
                    -> setCreateAt( $faker -> dateTimeBetween(+1) );
            $this -> addReference( self::getReferenceKey($i), $compte);
            $manager -> persist($compte);
        }

        $manager->flush();
    }
}
