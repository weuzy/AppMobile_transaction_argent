<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\CompteDeTransactionRepository;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=CompteDeTransactionRepository::class)
 * @UniqueEntity(
 *      fields = {"numeroCompte"},
 *      message = {"Le numéro compte existe déjà, veuillez choisir un autre"}
 * )
 * @ApiResource(
 *      normalizationContext = {"groups" = {"admin:read"}},
 *      denormalizationContext = {"groups" = {"admin:write"}},
 *      attributes = {"security_message" = "vous n'avez pas accés à cette ressource"},
 *      routePrefix = "/19weuzy",
 *      collectionOperations = {"get"= {"security" = "is_granted('ROLE_AdminSysteme') or object"},
 *           "addCompte" = { "method" = "POST", "route_name" = "addCompte",
 *                      "security" = "is_granted('ROLE_AdminSysteme')"}},
 *      itemOperations = {"get"= {"security" = "is_granted('ROLE_AdminSysteme') or object"},
 *           "put" = {"security" = "is_granted('ROLE_AdminSysteme')"},
 *           "delete" = {"security" = "is_granted('ROLE_AdminSysteme')"}}
 * )
 *
 */
class CompteDeTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "admin:read",
     *      "admin:write",
     *      "agence:read",
     *      "agence:write",
     *      "Trans:read","Trans:write",
     *      "dep:read", "dep:write",
     *      "connectUser"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({
     *      "admin:read",
     *      "admin:write",
     *      "agence:read",
     *      "agence:write",
     *      "Trans:read",
     *      "dep:read", "dep:write"
     * })
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="float")
     * @Groups({
     *     "connectUser",
     *      "admin:read",
     *      "admin:write",
     *      "agence:read",
     *      "agence:write",
     *      "Trans:read","Trans:write",
     *      "dep:read", "dep:write"
     * })
     */
    private $solde = 700000;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups({
     *      "admin:read",
     *      "admin:write",
     *      "agence:read",
     *      "agence:write",
     *      "connectUser"
     * })
     */
    private $createAt;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups({
     *      "admin:read",
     *      "agence:read",
     *      "dep:read", "dep:write"
     * })
     */
    private $statut;


    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compte")
     * @Groups({"connectUser", "admin:read"})
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="comptes")
     * @Groups({"connectUser"})
     */
    private $depots;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->statut = false;
        $this->numeroCompte = substr(md5(time()), 0, 10);
        $this->createAt = new DateTime();
        $this->depots = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSolde(): ?float
    {
        //return number_format($this->solde, null, null, ' ');
        return  $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setComptes($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getComptes() === $this) {
                $depot->setComptes(null);
            }
        }

        return $this;
    }

}
