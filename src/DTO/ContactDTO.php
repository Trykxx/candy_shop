<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\NotBlank(message: 'Le champ {{ label }} ne doit pas être vide')]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Le champ {{ label }} ne doit pas être vide')]
    private ?string $name = null;

    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'Le champ {{ label }} ne doit pas être vide'),
        new Assert\Length(min: 10, minMessage: 'Le champ {{ label }} doit contenir {{ limit }} caracteres minimum')
    ])]
    private ?string $message = null;

    #[Assert\NotBlank(message: 'Le champ {{ label }} ne doit pas être vide')]
    private string $service;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setmessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }
}
