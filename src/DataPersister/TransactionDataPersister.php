<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Services\GenerateServices;
use App\Services\TransactionServices;
use Doctrine\ORM\EntityManagerInterface;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;
    private $transactionService;
    private $generate;
    public function  __construct(
        EntityManagerInterface $em,
        TransactionServices $transactionService,
        GenerateServices $generate)
    {
        $this -> em = $em;
        $this -> transactionService = $transactionService;
        $this -> generate = $generate;
    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Transaction;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        $ttc = $this ->transactionService -> calculatriceFrais($data -> getMontant());
        $data -> setTTC($ttc)
              -> setCodeTransaction($this -> generate -> generateCodeTransaction());
        $parts = $this -> transactionService -> commisions($ttc);
        $data -> setFraisEtat($parts['fraisEtat'])
              -> setFraisDepot($parts['fraisDepot'])
              -> setFraisRetrait($parts['fraisRetrait'])
              -> setFraisSystem($parts['fraisSystem']);
        $soldeCompte = $data -> getCompte() -> getSolde();
        $soldeTransmis = $data -> getMontant() - $ttc;
        if ($data -> getIsDepot()) {
            $data -> getCOmpte() -> setSolde($soldeCompte + $soldeTransmis);
        }else {
            if ($soldeCompte > $soldeTransmis) {
                $data -> getCompte() -> setSolde($soldeCompte - $soldeTransmis);
            }
        }
        $this -> em -> persist($data);
        $this -> em -> flush();
        return $data;


    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}
