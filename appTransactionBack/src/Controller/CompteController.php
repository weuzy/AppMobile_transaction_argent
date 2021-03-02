<?php

namespace App\Controller;

use App\Entity\CompteDeTransaction;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompteController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> manager = $manager;
    }
    /**
     * @Route(
     *     name="addCompte",
     *     path="/api/19weuzy/compteTransaction",
     *     methods={"POST"}
     * )
     */
    public function addCompte()
    {
        $compte = new CompteDeTransaction();

        //Generate random account number
        $randomAccountNumber= rand(100000000,9999999999);
        $compte -> setNumeroCompte($randomAccountNumber)
                -> setCreateAt(new DateTime());
        dd($compte);
        $this -> manager -> persist($compte);
        $this -> manager -> flush();
    }

}
