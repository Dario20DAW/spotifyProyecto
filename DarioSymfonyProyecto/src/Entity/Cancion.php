<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionRepository::class)]
class Cancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $duracion = null;

    #[ORM\Column(length: 255)]
    private ?string $album = null;

    #[ORM\Column(length: 255)]
    private ?string $autor = null;

    #[ORM\ManyToOne(targetEntity: Estilo::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Estilo $genero = null;

    #[ORM\Column]
    private ?int $reproducciones = null;

    #[ORM\Column]
    private ?int $likes = null;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'cancion')]
    private Collection $playlistCancions;

    /**
     * @var Collection<int, Usuario>
     */
    // En Cancion
    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'canciones')]
    private Collection $usuarios;

    #[ORM\Column(length: 255)]
    private ?string $imagenCancion = null;



    public function __construct()
    {
        $this->playlistCancions = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): static
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(string $album): static
    {
        $this->album = $album;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): static
    {
        $this->autor = $autor;

        return $this;
    }

    public function getGenero(): ?Estilo
    {
        return $this->genero;
    }

    public function setGenero(?Estilo $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(int $reproducciones): static
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return Collection<int, PlaylistCancion>
     */
    public function getPlaylistCancions(): Collection
    {
        return $this->playlistCancions;
    }

    public function addPlaylistCancion(PlaylistCancion $playlistCancion): static
    {
        if (!$this->playlistCancions->contains($playlistCancion)) {
            $this->playlistCancions->add($playlistCancion);
            $playlistCancion->setCancion($this);
        }

        return $this;
    }

    public function removePlaylistCancion(PlaylistCancion $playlistCancion): static
    {
        if ($this->playlistCancions->removeElement($playlistCancion)) {
            // set the owning side to null (unless already changed)
            if ($playlistCancion->getCancion() === $this) {
                $playlistCancion->setCancion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): static
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->addCancione($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): static
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeCancione($this);
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->titulo;
    }

    public function getImagenCancion(): ?string
    {
        return $this->imagenCancion;
    }

    public function setImagenCancion(string $imagenCancion): static
    {
        $this->imagenCancion = $imagenCancion;

        return $this;
    }
}
