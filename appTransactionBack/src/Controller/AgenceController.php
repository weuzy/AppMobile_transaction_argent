<?php

namespace App\Controller;

use App\Entity\Agence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgenceController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> manager = $manager;
    }
    /**
     * @Route(
     *     name="addAgence",
     *     path="/api/19weuzy/agence",
     *     methods={"POST"}
     * )
     */
    public function addAgence() {
        
    }
}
