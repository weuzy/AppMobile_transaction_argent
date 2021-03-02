<?php


namespace App\DataPersister;


use App\Entity\Agence;
use App\Exception\AgenceException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AgenceDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     *@var EntityManagerInterface
     */
    protected $_em;
    protected $userRepo;
    protected $encoder;
    protected $serializer;
    public function __construct(EntityManagerInterface $_em, UserRepository $userRepo, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer)
    {
        $this -> _em = $_em;
        $this -> userRepo = $userRepo;
        $this -> encoder = $encoder;
        $this -> serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Agence;
    }

    /**
     * @param Agence $data
     */
    public function persist($data, array $context = [])
    {

        $solde = $data -> getCompte() -> getSolde();
        if ($solde >= 700000) {
            $data -> getCompte() -> setSolde($solde);
            $data -> setNom($data -> getNom());
            $this-> _em -> persist($data);
            $this-> _em -> flush();

            return $data;
        } else {
            throw new AgenceException("la solde du compte doit être rechargé au moins 700000");
        }
        dd($data);

        
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        $data -> setStatut(1);
        $this -> _em -> persist($data);
        $this -> _em -> flush();
    }
}
