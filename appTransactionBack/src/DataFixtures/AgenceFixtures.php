<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AgenceFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceAgenceKey($i) {
        return 'agence' . $i;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $k = 1;
        for ($i = 1; $i <= 5; $i++) {
            $agence = new Agence();
            $agence -> setNom( $faker -> company)
                    -> setAdresse( $faker -> streetAddress)
                    -> setCompte( $this -> getReference(CompteFixtures::getReferenceKey($i)))
                    -> addUser( $this -> getReference(UserFixtures::addReferenceAdminAgence($i)));
                for ( $j = 1; $j <= 2; $j++) {
                    $agence -> addUser( $this -> getReference(UserFixtures::addReferenceUtilisateurAgence($k)));
                    $k++;
                }
            $this -> addReference( self::getReferenceAgenceKey($i), $agence );
            $manager -> persist($agence);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
          UserFixtures::class,
          CompteFixtures::class
        );
    }
}
