<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Depot;
use Doctrine\ORM\EntityManagerInterface;

class DepotDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this -> em = $em;
    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Depot;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        $soldeCompte = $data -> getComptes() -> getSolde();
        $depot = $data -> getMontantDepot();
        $data -> getComptes() -> setSolde($soldeCompte + $depot);
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
