<?php

namespace App\Entity;

use App\Repository\CandyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandyRepository::class)]
class Candy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Sequentially([
        // new Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide'),
        new Assert\Length(min: 10,minMessage:'Le champ {{ label }} doit contenir {{ limit }} caracteres minimum')
    ])]
    #[ORM\Column(length: 255)]
    // #[Assert\NotBlank(message:'Le champ {{ value }} ne doit pas être vide')]
    // #[Assert\Length(min: 10,minMessage:'10 caracteres minimum')]
    private string $name = '';

    #[Assert\NotBlank(message:'Le champ {{ label }} ne doit pas être vide')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
