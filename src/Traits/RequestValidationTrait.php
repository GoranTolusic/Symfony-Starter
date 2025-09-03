<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Custom\ValidationException;

trait RequestValidationTrait
{
    public function validateRequestDto(Request $request, string $dtoClass, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true) ?? [];

        // Map fields from dto
        $dtoProps = array_map(fn($prop) => $prop->getName(), (new \ReflectionClass($dtoClass))->getProperties());

        // Sync with dto fields
        $filteredData = array_filter(
            $data,
            fn($key) => in_array($key, $dtoProps),
            ARRAY_FILTER_USE_KEY
        );

        // Instance new dto object
        $dto = new $dtoClass();
        foreach ($filteredData as $key => $value) {
            $dto->$key = $value;
        }

        // Validate and format error validations
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
        
            $exception = new ValidationException('Validation failed');
            // Assigning validations to exception for complete response
            $exception->validations = $messages;
        
            throw $exception;
        }

        return $dto;
    }
}
