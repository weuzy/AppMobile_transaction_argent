<?php

namespace App\DataFixtures;

use App\Entity\TypeDeTransactionClient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeTransactionClientFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceTypeCLITransKey($i) {
        return 'typeTransCli' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 5; $i++) {
            $typCliTR = new TypeDeTransactionClient();
            $typCliTR -> setType( $faker -> randomElement(['Dépôt', 'Retrait']) )
                      -> setTransactions( $this -> getReference(TransactionFixtures::getReferenceKey($i)))
                      -> setClients( $this -> getReference(ClientFixtures::getReferenceClientKey($i)));
            $this -> addReference( self::getReferenceTypeCLITransKey($i), $typCliTR);
            $manager -> persist($typCliTR);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ClientFixtures::class,
            TransactionFixtures::class
        );
    }
}
