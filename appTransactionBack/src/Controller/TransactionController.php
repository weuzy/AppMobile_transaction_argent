<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\CompteDeTransactionRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Services\GenerateServices;
use App\Services\TransactionServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionController extends AbstractController
{
    private $transactionService;
    private $generate;
    private $em;
    private $repoTrans;
    private $userRepo;
    private $compteRepo;
    public function  __construct(
        EntityManagerInterface $em,
        UserRepository $userRepo,
        CompteDeTransactionRepository $compteRepo,
        TransactionServices $transactionService,
        TransactionRepository $repoTrans,

        GenerateServices $generate)
    {
        $this -> em = $em;
        $this -> transactionService = $transactionService;
        $this -> generate = $generate;
        $this -> repoTrans = $repoTrans;
        $this -> userRepo = $userRepo;
        $this -> compteRepo = $compteRepo;

    }
    /**
     * @Route(path="/api/19weuzy/envoiTransaction", name="envoiTransaction", methods="post")
     */
    public function envoiTransaction(Request $request, SerializerInterface $serializer)
    {
        $transaction = $request -> toArray();
        $userId = $this ->getUser()->getId();
        $compteId = $this -> userRepo ->find($userId)->getAgence()->getCompte()->getId();
        $user = $this -> userRepo ->find($userId);
        $compte = $this -> compteRepo -> find($compteId);
        $soldeCompte = (int)($compte -> getSolde());
        $ttc = $this ->transactionService -> calculatriceFrais($transaction['montant']);
        $soldeTransmis = $transaction['montant'] - $ttc;
        $compte -> setSolde($soldeCompte + $soldeTransmis);
        $this -> em -> persist($compte);
        $parts = $this -> transactionService -> commisions($ttc);
        $envoi = new Transaction();
        $envoi -> setMontant($transaction['montant'])
               -> setCodeTransaction($this -> generate -> generateCodeTransaction())
               -> setTTC($ttc)
               -> setCodeTransaction($this -> generate -> generateCodeTransaction())
               -> setFraisEtat($parts['fraisEtat'])
               -> setFraisDepot($parts['fraisDepot'])
               -> setFraisRetrait($parts['fraisRetrait'])
               -> setFraisSystem($parts['fraisSystem'])
               -> setPrenomEmetteur($transaction['prenomEmetteur'])
               -> setNomEmetteur($transaction['nomEmetteur'])
               -> setCniEmetteur($transaction['cniEmetteur'])
               -> setTelephoneEmetteur($transaction['telephoneEmetteur'])
               -> setTelephoneRecepteur($transaction['telephoneRecepteur'])
               -> setPrenomRecepteur($transaction['prenomRecepteur'])
               -> setNomRecepteur($transaction['nomRecepteur'])
               -> setStatut('en cours')
               -> setCompte($compte)
               -> setUser($user);
        $this -> em -> persist($envoi);
        $user -> addTransaction($envoi);

        $this -> em -> flush();
        $serializer -> normalize($envoi, 'JSON', ['groups' => 'depotTrans']);
        return new JsonResponse('votre dépot est envoyé avec success', Response::HTTP_OK);
    }
    /**
     * @Route(path="/api/19weuzy/retraitTransaction/{code}", name="retraitTransaction", methods="put")
     */
    public function retraitTransaction($code, Request  $request, SerializerInterface $serializer)
    {
        $transaction = $this -> repoTrans -> findByCodeTransaction($code);
        $montantAretirer = $transaction[0] -> getMontant();
        $compteId = $this -> userRepo -> find($this -> getUser() -> getId())-> getAgence() -> getCompte() -> getId();
        $compte = $this -> compteRepo -> find($compteId);
        $soldeCompte = (int)($compte -> getSolde());
        $compte -> setSolde($soldeCompte - $montantAretirer);
        if ($transaction) {
            if($transaction[0] -> getStatut() === 'retiré') {
                return new JsonResponse('cette transaction est déjà retiré', Response::HTTP_BAD_REQUEST);
            } elseif ($transaction[0] -> getStatut() === 'annulée') {
                return new JsonResponse('cette transaction a été annulée', Response::HTTP_BAD_REQUEST);
            } else {
                $data = $request -> toArray();
                $transaction[0] -> setStatut('retiré')
                             -> setDateRetrait(new \DateTime())
                             -> setCniRecepteur($data['cniRecepteur'])
                             -> setCompte($compte);
                $this -> em -> flush();
                $serializer -> normalize($transaction[0], 'JSON', ['groups' => 'retraitTrans']);
                return new JsonResponse('la  transaction vient d\'être retiré avec success', Response::HTTP_OK);
            }
        } else {
            return new JsonResponse('cette  n\'existe pas', Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @Route(path="/api/19weuzy/annulationTransaction/{id}", name="annulationTransaction", methods="put")
     */
    public function annulationTransaction(int $id, Request  $request, SerializerInterface $serializer) {
        $transaction = $this -> repoTrans -> find($id);
        $montantDeposer = $transaction -> getMontant();
        $frais = $transaction -> getTTC();
        $montantArembourser = $montantDeposer - $frais;
        $compteId = $this -> userRepo -> find($this -> getUser() -> getId())-> getAgence() -> getCompte() -> getId();
        $compte = $this -> compteRepo -> find($compteId);
        $soldeCompte = (int)($compte -> getSolde());
        $compte -> setSolde($soldeCompte - $montantArembourser);
        if ($transaction) {
            if ($transaction -> getStatut() === 'retiré') {
                return new JsonResponse('cette transaction est déjà retiré', Response::HTTP_BAD_REQUEST);
            } elseif ($transaction -> getStatut() === 'annulée') {
                return new JsonResponse('cette transaction a été annulée', Response::HTTP_BAD_REQUEST);
            } else {
                $transaction -> setDateAnnulation(new \DateTime())
                             -> setStatut('annulée')
                             -> setCompte($compte);
                $this -> em -> flush();
                $serializer -> normalize($transaction, 'JSON', ['groups' => 'retraitTrans']);
                return new JsonResponse('la  transaction vient d\'être annulée avec success', Response::HTTP_OK);
            }
        } else {
            return new JsonResponse('cette  n\'existe pas', Response::HTTP_BAD_REQUEST);
        }

    }
}
