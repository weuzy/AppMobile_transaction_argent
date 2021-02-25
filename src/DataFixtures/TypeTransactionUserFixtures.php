<?php

namespace App\DataFixtures;

use App\Entity\TypeDeTransactionUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeTransactionUserFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceTypeTransKey($i) {
        return 'typeTransUser' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $k = 1;
        for ($i = 1; $i <= 3; $i++) {
            $typeTra = new TypeDeTransactionUser();
            $typeTra -> setType( $faker -> randomElement(['Dépôt', 'Retrait']))
                     -> setTransactions( $this -> getReference(TransactionFixtures::getReferenceKey($i)))
                     -> setUsers($this -> getReference(UserFixtures::addReferenceAdminAgence($i)));
            for ( $j = 1; $j <= 2; $j++) {
                $typeTra -> setUsers( $this -> getReference(UserFixtures::addReferenceUtilisateurAgence($k)));
                $k++;
            }
            $this -> addReference( self::getReferenceTypeTransKey($i), $typeTra);
            $manager -> persist($typeTra);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TransactionFixtures::class
        );
    }
}
