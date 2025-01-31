<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerfilRepository::class)]
class Perfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Estilo>
     */
    #[ORM\ManyToMany(targetEntity: Estilo::class, inversedBy: 'perfils')]
    private Collection $estilos;

    public function __construct()
    {
        $this->estilos = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Estilo>
     */
    public function getEstilos(): Collection
    {
        return $this->estilos;
    }

    public function addEstilo(Estilo $estilo): static
    {
        if (!$this->estilos->contains($estilo)) {
            $this->estilos->add($estilo);
        }

        return $this;
    }

    public function removeEstilo(Estilo $estilo): static
    {
        $this->estilos->removeElement($estilo);

        return $this;
    }


}
