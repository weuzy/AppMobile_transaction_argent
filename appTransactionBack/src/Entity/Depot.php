<?php

namespace App\Entity;

use App\Repository\DepotRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 * @ApiResource(
 *     normalizationContext = {"groups" = {"dep:read"}},
 *      denormalizationContext = {"groups" = {"dep:write"}},
 *      attributes = {
 *          "security" = "is_granted('ROLE_AdminSysteme') or is_granted('ROLE_Caissier')",
 *          "security_message" = "vous n'avez pas accés à cette ressource",
 *        },
 *     routePrefix = "/19weuzy/compte",
 *      collectionOperations = {"get", "post"},
 *      itemOperations = {"get","delete"}
 * )
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *      "dep:read",
     *      "dep:write",
     *      "connectUser"
     *})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({
     *      "dep:read",
     *      "dep:write",
     *      "connectUser"
     *})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="integer")
     * @Groups({
     *      "dep:read",
     *      "dep:write"
     *})
     */
    private $montantDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depots")
     * @Groups({
     *      "dep:read",
     *      "dep:write"
     *})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=CompteDeTransaction::class, inversedBy="depots")
     * @Groups({
     *      "dep:read",
     *      "dep:write"
     *})
     */
    private $comptes;

    public function __construct() {
        $this -> dateDepot = new DateTime();
}

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMontantDepot(): ?int
    {
        return $this->montantDepot;
    }

    public function setMontantDepot(int $montantDepot): self
    {
        $this->montantDepot = $montantDepot;

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

    public function getComptes(): ?CompteDeTransaction
    {
        return $this->comptes;
    }

    public function setComptes(?CompteDeTransaction $comptes): self
    {
        $this->comptes = $comptes;

        return $this;
    }
}
