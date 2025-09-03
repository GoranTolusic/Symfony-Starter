<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDto extends BaseAbstractDto
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\NotNull(message: 'Email cannot be null.')]
    public $email;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\NotNull(message: 'Password cannot be null.')]
    public $password;
}
