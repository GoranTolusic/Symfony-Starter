<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateProfileDto extends BaseAbstractDto
{
    #[Assert\Type('string')]
    #[Assert\NotNull(message: 'First name cannot be null.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'First name must be at least {{ limit }} characters long.',
        maxMessage: 'First name cannot be longer than {{ limit }} characters.'
    )]
    public $first_name;
    
    #[Assert\Type('string')]
    #[Assert\NotNull(message: 'Last name cannot be null.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Last name must be at least {{ limit }} characters long.',
        maxMessage: 'Last name cannot be longer than {{ limit }} characters.'
    )]
    public $last_name;
}
