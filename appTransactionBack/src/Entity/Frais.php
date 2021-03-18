<?php

namespace App\Entity;

use App\Repository\FraisRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=FraisRepository::class)
 * @ApiResource(
 *      normalizationContext = {"groups" = {"frais:read"}},
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
class Frais
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"frais:read"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="float")
     * @Groups({"frais:read"})
     */
    private $fraisSystem;

    /**
     * @ORM\Column(type="float")
     * @Groups({"frais:read"})
     */
    private $fraisEnvoie;

    /**
     * @ORM\Column(type="float")
     * @Groups({"frais:read"})
     */
    private $fraisRetrait;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFraisEnvoie(): ?float
    {
        return $this->fraisEnvoie;
    }

    public function setFraisEnvoie(float $fraisEnvoie): self
    {
        $this->fraisEnvoie = $fraisEnvoie;

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

}
