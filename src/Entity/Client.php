<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numCNI;

    /**
     * @ORM\OneToMany(targetEntity=TypeDeTransactionClient::class, mappedBy="clients")
     */
    private $typeDeTransactionClients;

    public function __construct()
    {
        $this->typeDeTransactionClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

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

    public function getNumCNI(): ?string
    {
        return $this->numCNI;
    }

    public function setNumCNI(string $numCNI): self
    {
        $this->numCNI = $numCNI;

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
            $typeDeTransactionClient->setClients($this);
        }

        return $this;
    }

    public function removeTypeDeTransactionClient(TypeDeTransactionClient $typeDeTransactionClient): self
    {
        if ($this->typeDeTransactionClients->removeElement($typeDeTransactionClient)) {
            // set the owning side to null (unless already changed)
            if ($typeDeTransactionClient->getClients() === $this) {
                $typeDeTransactionClient->setClients(null);
            }
        }

        return $this;
    }
}
