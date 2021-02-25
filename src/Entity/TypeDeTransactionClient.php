<?php

namespace App\Entity;

use App\Repository\TypeDeTransactionClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeDeTransactionClientRepository::class)
 */
class TypeDeTransactionClient
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="typeDeTransactionClients")
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=Transaction::class, inversedBy="typeDeTransactionClients")
     */
    private $transactions;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(?Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    public function getTransactions(): ?Transaction
    {
        return $this->transactions;
    }

    public function setTransactions(?Transaction $transactions): self
    {
        $this->transactions = $transactions;

        return $this;
    }
}
