<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Perfil $perfil = null;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'propietario')]
    private Collection $playlists;

    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuarioPlaylists;

    #[ORM\ManyToMany(targetEntity: Cancion::class, inversedBy: 'usuarios')]
    private Collection $canciones;

    public function __construct()
    {
        $this->roles = ['ROLE_USER']; // Asegurar que siempre tenga al menos un rol
        $this->playlists = new ArrayCollection();
        $this->usuarioPlaylists = new ArrayCollection();
        $this->canciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return array($this->roles);
    }

    public function setRoles(array $roles): static
    {

        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;
        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil): static
    {
        $this->perfil = $perfil;
        return $this;
    }

    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setPropietario($this);
        }
        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            if ($playlist->getPropietario() === $this) {
                $playlist->setPropietario(null);
            }
        }
        return $this;
    }

    public function getUsuarioPlaylists(): Collection
    {
        return $this->usuarioPlaylists;
    }

    public function addUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if (!$this->usuarioPlaylists->contains($usuarioPlaylist)) {
            $this->usuarioPlaylists->add($usuarioPlaylist);
            $usuarioPlaylist->setUsuario($this);
        }
        return $this;
    }

    public function removeUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if ($this->usuarioPlaylists->removeElement($usuarioPlaylist)) {
            if ($usuarioPlaylist->getUsuario() === $this) {
                $usuarioPlaylist->setUsuario(null);
            }
        }
        return $this;
    }

    public function getCanciones(): Collection
    {
        return $this->canciones;
    }

    public function addCancione(Cancion $cancione): static
    {
        if (!$this->canciones->contains($cancione)) {
            $this->canciones->add($cancione);
        }
        return $this;
    }

    public function removeCancione(Cancion $cancione): static
    {
        $this->canciones->removeElement($cancione);
        return $this;
    }
}
