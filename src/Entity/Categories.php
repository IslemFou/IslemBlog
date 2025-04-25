<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\HasLifecycleCallbacks] // signifie que la méthode annotée sera appelée juste avant que l'entité soit mise à jour dans la base de données, c'est-à-dire juste avant l'exécution de la requête SQL de mise à jour.
#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'category')]
    private Collection $articless;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->articless = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')); // date de creation de la categorie par defaut
    }

    //on va créer une fonction qui va permettre de mettre la date update par defaut
    #[ORM\PreUpdate]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticless(): Collection
    {
        return $this->articless;
    }

    public function addArticless(Article $articless): static
    {
        if (!$this->articless->contains($articless)) {
            $this->articless->add($articless);
            $articless->addCategory($this);
        }

        return $this;
    }

    public function removeArticless(Article $articless): static
    {
        if ($this->articless->removeElement($articless)) {
            $articless->removeCategory($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
