<?php

namespace App\Dto;

use App\Dto\BaseAbstractDto;
use Symfony\Component\Validator\Constraints as Assert;

class FilterUserDto extends BaseAbstractDto
{
    #[Assert\Length(
        max: 200,
        maxMessage: "Term cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Type(
        type: 'string',
        message: 'Term must be a string.'
    )]
    public ?string $term = null; // opcionalan, može biti null

    #[Assert\NotBlank(message: "Page is required.")]
    #[Assert\Type(
        type: 'integer',
        message: 'Page must be an integer.'
    )]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'Page must be at least {{ compared_value }}.'
    )]
    public int $page;

    #[Assert\NotBlank(message: "Limit is required.")]
    #[Assert\Type(
        type: 'integer',
        message: 'Limit must be an integer.'
    )]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'Limit must be at least {{ compared_value }}.'
    )]
    #[Assert\LessThanOrEqual(
        value: 20,
        message: 'Limit cannot be more than {{ compared_value }}.'
    )]
    public int $limit;
}
