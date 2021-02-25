<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeTransaction;

    /**
     * @ORM\Column(type="float")
     */
    private $TTC;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisSystem;

    /**
     * @ORM\OneToMany(targetEntity=TypeDeTransactionUser::class, mappedBy="transactions")
     */
    private $typeDeTransactionUsers;

    /**
     * @ORM\OneToMany(targetEntity=TypeDeTransactionClient::class, mappedBy="transactions")
     */
    private $typeDeTransactionClients;

    /**
     * @ORM\ManyToOne(targetEntity=CompteDeTransaction::class, inversedBy="transactions")
     */
    private $compte;

    public function __construct()
    {
        $this->typeDeTransactionUsers = new ArrayCollection();
        $this->typeDeTransactionClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCodeTransaction(): ?string
    {
        return $this->codeTransaction;
    }

    public function setCodeTransaction(string $codeTransaction): self
    {
        $this->codeTransaction = $codeTransaction;

        return $this;
    }

    public function getTTC(): ?float
    {
        return $this->TTC;
    }

    public function setTTC(float $TTC): self
    {
        $this->TTC = $TTC;

        return $this;
    }

    public function getFraisDepot(): ?float
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(float $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?float
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(float $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisEtat(): ?float
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(float $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSystem(): ?float
    {
        return $this->fraisSystem;
    }

    public function setFraisSystem(float $fraisSystem): self
    {
        $this->fraisSystem = $fraisSystem;

        return $this;
    }

    /**
     * @return Collection|TypeDeTransactionUser[]
     */
    public function getTypeDeTransactionUsers(): Collection
    {
        return $this->typeDeTransactionUsers;
    }

    public function addTypeDeTransactionUser(TypeDeTransactionUser $typeDeTransactionUser): self
    {
        if (!$this->typeDeTransactionUsers->contains($typeDeTransactionUser)) {
            $this->typeDeTransactionUsers[] = $typeDeTransactionUser;
            $typeDeTransactionUser->setTransactions($this);
        }

        return $this;
    }

    public function removeTypeDeTransactionUser(TypeDeTransactionUser $typeDeTransactionUser): self
    {
        if ($this->typeDeTransactionUsers->removeElement($typeDeTransactionUser)) {
            // set the owning side to null (unless already changed)
            if ($typeDeTransactionUser->getTransactions() === $this) {
                $typeDeTransactionUser->setTransactions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TypeDeTransactionClient[]
     */
    public function getTypeDeTransactionClients(): Collection
    {
        return $this->typeDeTransactionClients;
    }

    public function addTypeDeTransactionClient(TypeDeTransactionClient $typeDeTransactionClient): self
    {
        if (!$this->typeDeTransactionClients->contains($typeDeTransactionClient)) {
            $this->typeDeTransactionClients[] = $typeDeTransactionClient;
            $typeDeTransactionClient->setTransactions($this);
        }

        return $this;
    }

    public function removeTypeDeTransactionClient(TypeDeTransactionClient $typeDeTransactionClient): self
    {
        if ($this->typeDeTransactionClients->removeElement($typeDeTransactionClient)) {
            // set the owning side to null (unless already changed)
            if ($typeDeTransactionClient->getTransactions() === $this) {
                $typeDeTransactionClient->setTransactions(null);
            }
        }

        return $this;
    }

    public function getCompte(): ?CompteDeTransaction
    {
        return $this->compte;
    }

    public function setCompte(?CompteDeTransaction $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
