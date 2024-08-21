<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Illustration>
     */
    #[ORM\ManyToMany(targetEntity: Illustration::class, mappedBy: 'category')]
    private Collection $illustration;

    /**
     * @var Collection<int, Illustration>
     */

    public function __construct()
    {
        $this->illustrations = new ArrayCollection();
        $this->illustration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Illustration>
     */
    public function getIllustration(): Collection
    {
        return $this->illustration;
    }

    public function addIllustration(Illustration $illustration): static
    {
        if (!$this->illustration->contains($illustration)) {
            $this->illustration->add($illustration);
            $illustration->addCategory($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): static
    {
        if ($this->illustration->removeElement($illustration)) {
            $illustration->removeCategory($this);
        }

        return $this;
    }

}
