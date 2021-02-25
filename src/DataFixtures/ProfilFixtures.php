<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public static function getReferencekey($i)
    {
        return 'profil' . $i;
    }

    public function load(ObjectManager $manager)
    {
        $profils = ['AdminSysteme', 'Caissier', 'AdminAgence', 'UtilisateurAgence'];
        for ($i = 0; $i <= 3; $i++) {
            $profil = new Profil();
            $profil -> setLibelle($profils[$i]);
            $this -> addReference(self :: getReferenceKey($i), $profil);
            $manager -> persist($profil);
        }
        $manager->flush();
    }
}
