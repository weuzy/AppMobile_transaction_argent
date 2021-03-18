<?php

namespace App\Entity;

use App\Repository\CommissionRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommissionRepository::class)
 * @ApiResource(
 *      normalizationContext = {"groups" = {"com:read"}},
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
class Commission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"com:read"})
     */
    private $borneSup;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"com:read"})
     */
    private $borneInf;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"com:read"})
     */
    private $fraisEnvoie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneSup(): ?int
    {
        return $this->borneSup;
    }

    public function setBorneSup(int $borneSup): self
    {
        $this->borneSup = $borneSup;

        return $this;
    }

    public function getBorneInf(): ?int
    {
        return $this->borneInf;
    }

    public function setBorneInf(int $borneInf): self
    {
        $this->borneInf = $borneInf;

        return $this;
    }

    public function getFraisEnvoie(): ?int
    {
        return $this->fraisEnvoie;
    }

    public function setFraisEnvoie(int $fraisEnvoie): self
    {
        $this->fraisEnvoie = $fraisEnvoie;

        return $this;
    }
}
