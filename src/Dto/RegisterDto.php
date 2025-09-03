<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto extends BaseAbstractDto
{
    #[Assert\NotNull(message: 'Email cannot be null.')]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Type('string')]
    public $email;

    #[Assert\NotNull(message: 'First name cannot be null.')]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public $first_name;

    #[Assert\NotNull(message: 'Last name cannot be null.')]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public $last_name;

    #[Assert\NotNull(message: 'Password cannot be null.')]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 4, max: 8)]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/",
        message: "Password must contain at least one lowercase letter, one uppercase letter, and one number."
    )]
    public $password;

    #[Assert\Type('array')]
    #[Assert\Count(
        max: 10,
        maxMessage: 'You cannot specify more than {{ limit }} tags.'
    )]
    #[Assert\All([
        new Assert\Type('string'),
        new Assert\Length(
            max: 50,
            maxMessage: 'Each tag cannot be longer than {{ limit }} characters.'
        )
    ])]
    public $tags = [];

    public readonly int $created_at;

    public function __construct()
    {
        $this->created_at = time();
    }
}
