<?php

namespace App\Entity;

use App\Repository\EstiloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstiloRepository::class)]
class Estilo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Perfil>
     */
    #[ORM\ManyToMany(targetEntity: Perfil::class, mappedBy: 'estilos')]

    private Collection $perfils;



    public function __construct()
    {
        $this->perfils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

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
     * @return Collection<int, Perfil>
     */
    public function getPerfils(): Collection
    {
        return $this->perfils;
    }

    public function addPerfil(Perfil $perfil): static
    {
        if (!$this->perfils->contains($perfil)) {
            $this->perfils->add($perfil);
            $perfil->addEstilo($this);
        }

        return $this;
    }

    public function removePerfil(Perfil $perfil): static
    {
        if ($this->perfils->removeElement($perfil)) {
            $perfil->removeEstilo($this);
        }

        return $this;
    }



    public function __toString(): string
    {
        return $this->nombre ?? 'Sin nombre';
    }

}
