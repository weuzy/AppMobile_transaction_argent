<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements  DependentFixtureInterface
{
    protected $password;
    public function __construct(UserPasswordEncoderInterface $password) {
        $this -> password = $password;
    }

    public static function addReferenceAdminSysteme($i) {
        return 'as' . $i;
    }
    public static function addReferenceCaissier($i) {
        return 'cassier' . $i;
    }
    public static function addReferenceAdminAgence($i) {
        return 'ag' . $i;
    }
    public static function addReferenceUtilisateurAgence($i) {
        return 'ua' . $i;
    }

    public function load(ObjectManager $manager)
    {
        $tab = [];
        $faker = Factory::create('fr_FR');
        for ($j = 0; $j <= 3; $j++) {
            $profil = $this ->getReference(ProfilFixtures::getReferencekey($j));
            $tab[] = $j;

            $nbrUserProfil = '';
            if ($profil -> getLibelle() === 'AdminSysteme') {
                $nbrUserProfil = 2;
            }
            if ($profil -> getLibelle() === 'AdminAgence') {
                $nbrUserProfil = 5;
            }
            if ($profil -> getLibelle() === 'Caissier') {
                $nbrUserProfil = 4;
            }
            if ($profil -> getLibelle() === 'UtilisateurAgence') {
                $nbrUserProfil = 20;
            }

            for ($i = 1; $i <= $nbrUserProfil; $i++) {
                $user = new User();

                $user -> setPrenom( $faker -> firstName )
                      -> setNom( $faker -> lastName )
                      -> setPhoto(fopen('https://librestock.com', 'rb'))
                      -> setEmail( $faker -> email )
                      -> setTelephone( $faker -> phoneNumber )
                      -> setUsername( $faker -> userName )
                      -> setPassword($this -> password -> encodePassword($user, '#19weuzy'))
                      -> setRoles(['ROLE_'.$profil -> getLiBelle()])
                      -> setProfil($profil);

                $manager -> persist($user);
                if ($profil -> getLibelle() === 'AdminSysteme') {
                    $this -> setReference(self::addReferenceAdminSysteme($i), $user);
                }
                elseif ($profil -> getLibelle() === 'Caissier') {
                    $this -> setReference(self::addReferenceCaissier($i), $user);
                }
                elseif ($profil -> getLibelle() === 'AdminAgence') {
                    $this -> setReference(self::addReferenceAdminAgence($i), $user);
                }
                elseif ($profil -> getLibelle() === 'UtilisateurAgence') {
                    $this -> setReference(self::addReferenceUtilisateurAgence($i), $user);

                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfilFixtures::class
        );
    }
}
