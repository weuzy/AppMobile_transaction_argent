<?php

namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TransactionFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceKey($i) {
        return 'transaction' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 5; $i++) {
            $transaction = new Transaction();
            $transaction -> setMontant( $faker -> numberBetween($min = 500, $max = 100000000))
                         -> setDateDepot( $faker -> dateTimeBetween(+1))
                         -> setDateRetrait( $faker -> dateTimeBetween(+1,5))
                         -> setCodeTransaction($faker -> isbn10)
                         -> setTTC($faker -> randomFloat())
                         -> setFraisDepot( $faker -> randomFloat())
                         -> setFraisEtat( $faker -> randomFloat() )
                         -> setFraisRetrait( $faker -> randomFloat() )
                         -> setFraisSystem( $faker -> randomFloat() )
                         -> setCompte( $this -> getReference(CompteFixtures::getReferenceKey($i)));
            $this -> addReference( self::getReferenceKey($i), $transaction);
            $manager -> persist($transaction);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CompteFixtures::class
        );
    }
}
