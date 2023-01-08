<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[Broadcast]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Single::class)]
    private Collection $single;

    public function __construct()
    {
        $this->single = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Single>
     */
    public function getSingle(): Collection
    {
        return $this->single;
    }

    public function addSingle(Single $single): self
    {
        if (!$this->single->contains($single)) {
            $this->single->add($single);
            $single->setGenre($this);
        }

        return $this;
    }

    public function removeSingle(Single $single): self
    {
        if ($this->single->removeElement($single)) {
            // set the owning side to null (unless already changed)
            if ($single->getGenre() === $this) {
                $single->setGenre(null);
            }
        }

        return $this;
    }
}
