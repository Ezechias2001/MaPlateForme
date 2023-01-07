<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
#[Broadcast]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPlaylist = null;

    #[ORM\Column(length: 255)]
    private ?string $ImagePlaylist = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\ManyToMany(targetEntity: Single::class)]
    private Collection $piste;

    public function __construct()
    {
        $this->piste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlaylist(): ?string
    {
        return $this->NomPlaylist;
    }

    public function setNomPlaylist(string $NomPlaylist): self
    {
        $this->NomPlaylist = $NomPlaylist;
        return $this;
    }

    public function getImagePlaylist(): ?string
    {
        return $this->ImagePlaylist;
    }

    public function setImagePlaylist(string $ImagePlaylist): self
    {
        $this->ImagePlaylist = $ImagePlaylist;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Single>
     */
    public function getPiste(): Collection
    {
        return $this->piste;
    }

    public function addPiste(Single $piste): self
    {
        if (!$this->piste->contains($piste)) {
            $this->piste->add($piste);
        }

        return $this;
    }

    public function removePiste(Single $piste): self
    {
        $this->piste->removeElement($piste);
        return $this;
    }

}
