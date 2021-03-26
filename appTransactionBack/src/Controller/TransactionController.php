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
     * @Route(path="/api/19weuzy/calculatriceFrais", name="calculatriceFrais", methods="post")
     */
    public function calculatriceFrais(Request $request, SerializerInterface $serializer) {
        $data = $request -> toArray();
        if ($data['type'] === 'dépôt') {
            $ttc = $this -> transactionService -> calculatriceFrais($data['montant']);
            return new JsonResponse($ttc, Response::HTTP_OK);
        }
        return new JsonResponse('le type doit être \'dépôt\'', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/api/19weuzy/myTransactions", name="myTransactions", methods="get")
     */
    public function myTransactions(SerializerInterface $serializer) {
        $user  = $this ->getUser();
        $trans = [];
        foreach ($user->getTransactions() as $value) {
            $trans[] = $value;
        }
        $trans = $serializer -> normalize($trans, 'JSON', ['groups' => 'depotTrans']);
        return new JsonResponse($trans, Response::HTTP_OK);

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
               -> setType('dépot')
               -> setCompte($compte)
               -> setUser($user);
        $this -> em -> persist($envoi);
        $user -> addTransaction($envoi);

        $this -> em -> flush();
        $envoi = $serializer -> normalize($envoi, 'JSON', ['groups' => 'depotTrans']);
        return new JsonResponse($envoi, Response::HTTP_OK);
    }

    /**
     * @Route(path="/api/19weuzy/findCodeTransaction/{code}", name="findCodeTransaction", methods="get")
     */
    public function findCodeTransaction($code, SerializerInterface $serializer) {
        $transaction = $this -> repoTrans -> findByCodeTransaction($code);
         $transaction = $serializer -> normalize($transaction[0], 'JSON', ['groups' => 'depotTrans']);
        return new JsonResponse($transaction, Response::HTTP_OK);
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
                                -> setType('retrait')
                                -> setDateRetrait(new \DateTime())
                                -> setCniRecepteur($data['cniRecepteur'])
                                -> setCompte($compte);
                    $this -> em -> flush();
                    $serializer -> normalize($transaction[0], 'JSON', ['groups' => 'retraitTrans']);
                return new JsonResponse('la  transaction vient d\'être retiré avec success', Response::HTTP_OK);
            }
        } else {
            return new JsonResponse('cette transaction  n\'existe pas', Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @Route(path="/api/19weuzy/annulationTransaction/{code}", name="annulationTransaction", methods="put")
     */
    public function annulationTransaction($code, Request  $request, SerializerInterface $serializer) {
        $transaction = $this -> repoTrans -> findByCodeTransaction($code);
        $montantDeposer = $transaction[0] -> getMontant();
        $frais = $transaction[0] -> getTTC();
        $montantArembourser = $montantDeposer - $frais;
        $compteId = $this -> userRepo -> find($this -> getUser() -> getId())-> getAgence() -> getCompte() -> getId();
        $compte = $this -> compteRepo -> find($compteId);
        $soldeCompte = (int)($compte -> getSolde());
        $compte -> setSolde($soldeCompte - $montantArembourser);
        if ($transaction) {
            if ($transaction[0] -> getStatut() === 'retiré') {
                return new JsonResponse('cette transaction est déjà retiré', Response::HTTP_BAD_REQUEST);
            } elseif ($transaction[0] -> getStatut() === 'annulée') {
                return new JsonResponse('cette transaction a été annulée', Response::HTTP_BAD_REQUEST);
            } else {
                $transaction[0] -> setDateAnnulation(new \DateTime())
                                -> setStatut('annulée')
                                -> setType('dépot')
                                -> setCompte($compte);
                    $this -> em -> flush();
                    $serializer -> normalize($transaction[0], 'JSON', ['groups' => 'retraitTrans']);
                return new JsonResponse('la  transaction vient d\'être annulée avec success', Response::HTTP_OK);
            }
        } else {
            return new JsonResponse('cette transaction  n\'existe pas', Response::HTTP_BAD_REQUEST);
        }

    }
}
