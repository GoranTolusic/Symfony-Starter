<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDto extends BaseAbstractDto
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    public string $password;
}
