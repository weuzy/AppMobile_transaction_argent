<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *      normalizationContext = {"groups" = {"Trans:read"}},
 *      denormalizationContext = {"groups" = {"Trans:write"}},
 *      attributes = {
 *          "security" = "is_granted('ROLE_AdminAgence') or is_granted('ROLE_UtilisateurAgence')",
 *          "security_message" = "vous n'avez pas accés à cette ressource",
 *          "pagination_enabled" = true,
 *          "pagination_items_per_page" = 8
 * },
 *      routePrefix = "/19weuzy",
 *      collectionOperations = {"get", "post"},
 *      itemOperations = {"get", "put"={"deserialize"=false}, "delete"}
 * )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Trans:read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","Trans:write"})
     */
    private $codeTransaction;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $TTC;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $fraisSystem;

    /**
     * @ORM\ManyToOne(targetEntity=CompteDeTransaction::class, inversedBy="transactions")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $compte;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Trans:read"})
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $isDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transactions")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $user;

    public function __construct()
    {
        $this->isDeleted = false;
        $this->dateDepot = new DateTime();
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

    public function getCompte(): ?CompteDeTransaction
    {
        return $this->compte;
    }

    public function setCompte(?CompteDeTransaction $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsDepot(): ?bool
    {
        return $this->isDepot;
    }

    public function setIsDepot(bool $isDepot): self
    {
        $this->isDepot = $isDepot;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
