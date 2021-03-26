<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiFilter;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
    *fields = {"username", "email", "telephone"},
    *message = "l'email, le username ou le numéro de téléphone est est déjà utilisé, veuillez choisir un autre" 
 * )
 * @ApiResource(
 *      normalizationContext = {"groups" = {"admin:read"}},
 *      denormalizationContext = {"groups" = {"admin:write"}},
 *      attributes = {
        * "security" = "is_granted('ROLE_AdminSysteme')",
        * "security_message" = "vous n'avez pas accés à cette ressource",
 * },
 *      routePrefix = "/19weuzy",
 *      collectionOperations = {"get",
 *            "getUserConnect" = { "method"= "GET", "route_name" = "getUserConnect"},
 *           "add_user" = {
 *           "method" = "POST",
 *           "route_name" = "add_user"}
 *      },
 *      itemOperations = {"get",
 *           "edit_user" = {
 *           "deserialize" = false,
 *           "method" = "PUT",
 *           "route_name" = "edit_user"},
 *        "delete"}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archive" : true})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"admin:read", "admin:write", "profil:read", "Trans:read","Trans:write", "dep:read", "dep:write", "agence:read", "agence:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"admin:read", "admin:write", "profil:read", "Trans:read","Trans:write", "dep:read", "dep:write", "agence:read", "agence:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"admin:read", "profil:read", "Trans:read","Trans:write", "dep:read", "dep:write", "agence:read"})
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"admin:write", "agence:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read", "connectUser", "admin:read", "admin:write", "profil:read", "Trans:read","Trans:write", "dep:read", "dep:write", "agence:read", "agence:write"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Trans:read", "connectUser", "admin:read", "admin:write", "profil:read", "Trans:read","Trans:write" , "dep:read", "dep:write", "agence:read", "agence:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:read", "admin:write", "profil:read", "Trans:read","Trans:write", "agence:read", "agence:write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"admin:read", "admin:write", "profil:read"})
     */
    private $isBlocked;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"connectUser","admin:read", "admin:write", "Trans:read", "agence:read", "agence:write"})
     */
    private $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"connectUser", "admin:write", "admin:read", "Trans:read","Trans:write"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     * @Groups({"connectUser", "admin:read", "Trans:read"})
     */
    private $agence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"connectUser", "admin:read", "admin:write", "Trans:read","Trans:write", "dep:read", "dep:write", "agence:read", "agence:write"})
     */
    private $username;


    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="users")
     * @Groups({"admin:read"})
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="user")
     */
    private $transactions;

    public function __construct() {
        $this->isBlocked = false;
        $this->depots = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this -> profil -> getLiBelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->statut = $isBlocked;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getPhoto()
    {
        $avatar = $this->photo;
        if (is_resource($avatar)) {
            return base64_encode(stream_get_contents($avatar));
        }
        return $avatar;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
            $depot->setUsers($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getUsers() === $this) {
                $depot->setUsers(null);
            }
        }

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
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }


}
