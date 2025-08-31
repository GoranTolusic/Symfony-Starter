<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto extends BaseAbstractDto
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public string $first_name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public string $last_name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 4, max: 8)]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/",
        message: "Password must contain at least one lowercase letter, one uppercase letter, and one number."
    )]
    public string $password;

    public readonly int $created_at;

    public function __construct()
    {
        $this->created_at = time();
    }
}
