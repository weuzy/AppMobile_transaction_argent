<?php

namespace App\DataFixtures;

use App\Entity\Depot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DepotFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceDepotKey($i) {
        return 'depot' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 4; $i++) {
            $depot = new Depot();
            $depot -> setDateDepot( $faker -> dateTimeBetween(+1))
                   -> setMontantDepot( $faker -> numberBetween($min = 700000, $max = 100000000))
                   -> setUsers( $this -> getReference(UserFixtures::addReferenceCaissier($i)));
            $this -> addReference( self::getReferenceDepotKey($i), $depot);
            $manager -> persist($depot);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
