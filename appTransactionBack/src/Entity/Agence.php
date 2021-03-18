<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @UniqueEntity(
 *      fields = {"nom"},
 *      message = {"Le nom de l'agence existe déjà, veuillez choisir un autre"}
 * )
 * @ApiResource(
 *      normalizationContext = {"groups" = {"agence:read"}},
 *      denormalizationContext = {"groups" = {"agence:write"}},
 *      attributes = {
 *          "security" = "is_granted('ROLE_AdminSysteme')",
 *          "security_message" = "vous n'avez pas accés à cette ressource",
 *          "pagination_enabled" = true,
 *          "pagination_items_per_page" = 3
 * },
 *      routePrefix = "/19weuzy",
 *      collectionOperations = {"get", "post"},
 *      itemOperations = {"get", "put", "delete"}
 * )
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"agence:read", "agence:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le nom ne peut pas être vide")
     * @Assert\Regex(
     * pattern = "/^[A-Z][a-z]+$/",
     * message = "le nom commence par un majuscule"
     * )
     * @Groups({"agence:read", "agence:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "l'adresse ne peut pas être vide")
     * @Groups({"agence:read", "agence:write"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"agence:read"})
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence")
     * @Groups({"agence:read"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=CompteDeTransaction::class, cascade={"persist", "remove"})
     * @Groups({"connectUser", "agence:read", "agence:write"})
     */
    private $compte;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this -> statut = false;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
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
