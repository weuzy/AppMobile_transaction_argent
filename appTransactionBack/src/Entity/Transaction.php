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
 *          "pagination_enabled" = false,
 *          "pagination_items_per_page" = 1
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
     * @Groups({"Trans:read","Trans:write","depotTrans"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Trans:read","Trans:write","depotTrans","retraitTrans"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Trans:read","depotTrans","connectUser","admin:read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"Trans:read","Trans:write","retraitTrans"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","Trans:write","depotTrans"})
     */
    private $codeTransaction;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:read","Trans:write"})
     */
    private $TTC;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:write"})
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:write"})
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:write"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Trans:write"})
     */
    private $fraisSystem;

    /**
     * @ORM\ManyToOne(targetEntity=CompteDeTransaction::class, inversedBy="transactions")
     * @Groups({"Trans:write"})
     */
    private $compte;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Trans:read"})
     */
    private $isDeleted;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     * @Groups({"Trans:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"Trans:read"})
     */
    private $dateAnnulation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $prenomEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $nomEmetteur;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $cniEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $prenomRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $nomRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $telephoneRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $telephoneEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"Trans:read","retraitTrans"})
     */
    private $cniRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read","depotTrans","retraitTrans"})
     */
    private $type;


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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateAnnulation(): ?\DateTimeInterface
    {
        return $this->dateAnnulation;
    }

    public function setDateAnnulation(?\DateTimeInterface $dateAnnulation): self
    {
        $this->dateAnnulation = $dateAnnulation;

        return $this;
    }

    public function getPrenomEmetteur(): ?string
    {
        return $this->prenomEmetteur;
    }

    public function setPrenomEmetteur(string $prenomEmetteur): self
    {
        $this->prenomEmetteur = $prenomEmetteur;

        return $this;
    }

    public function getNomEmetteur(): ?string
    {
        return $this->nomEmetteur;
    }

    public function setNomEmetteur(string $nomEmetteur): self
    {
        $this->nomEmetteur = $nomEmetteur;

        return $this;
    }

    public function getCniEmetteur(): ?int
    {
        return $this->cniEmetteur;
    }

    public function setCniEmetteur(int $cniEmetteur): self
    {
        $this->cniEmetteur = $cniEmetteur;

        return $this;
    }

    public function getPrenomRecepteur(): ?string
    {
        return $this->prenomRecepteur;
    }

    public function setPrenomRecepteur(string $prenomRecepteur): self
    {
        $this->prenomRecepteur = $prenomRecepteur;

        return $this;
    }

    public function getNomRecepteur(): ?string
    {
        return $this->nomRecepteur;
    }

    public function setNomRecepteur(string $nomRecepteur): self
    {
        $this->nomRecepteur = $nomRecepteur;

        return $this;
    }

    public function getTelephoneRecepteur(): ?string
    {
        return $this->telephoneRecepteur;
    }

    public function setTelephoneRecepteur(string $telephoneRecepteur): self
    {
        $this->telephoneRecepteur = $telephoneRecepteur;

        return $this;
    }

    public function getTelephoneEmetteur(): ?string
    {
        return $this->telephoneEmetteur;
    }

    public function setTelephoneEmetteur(string $telephoneEmetteur): self
    {
        $this->telephoneEmetteur = $telephoneEmetteur;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCniRecepteur(): ?int
    {
        return $this->cniRecepteur;
    }

    public function setCniRecepteur(int $cniRecepteur): self
    {
        $this->cniRecepteur = $cniRecepteur;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

}
