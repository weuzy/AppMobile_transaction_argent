<?php

namespace App\Entity;

use App\Repository\TypeDeTransactionUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeDeTransactionUserRepository::class)
 */
class TypeDeTransactionUser
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="typeDeTransactionUsers")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Transaction::class, inversedBy="typeDeTransactionUsers")
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

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

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
