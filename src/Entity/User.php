<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    #Tags relation
    #HINT: In my opinion very bad for real case scenarios, because of potential fetching large number of records
    #It's just better to use custom queries from repos for specific use cases
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Tag::class, cascade: ["persist", "remove"])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
}
