<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    public ?int $id = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    public string $email;

    #[ORM\Column(type: "string", length: 100)]
    public string $first_name;

    #[ORM\Column(type: "string", length: 100)]
    public string $last_name;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "bigint")]
    public int $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $email): self
    {
        $this->password = $password;
        return $this;
    }
}
