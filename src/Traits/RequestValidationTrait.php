<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait RequestValidationTrait
{
    public function validateRequestDto(Request $request, string $dtoClass, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true) ?? [];

        // Dohvati polja DTO-a
        $dtoProps = array_map(fn($prop) => $prop->getName(), (new \ReflectionClass($dtoClass))->getProperties());

        // Zadrži samo polja koja postoje u DTO-u
        $filteredData = array_filter(
            $data,
            fn($key) => in_array($key, $dtoProps),
            ARRAY_FILTER_USE_KEY
        );

        // Napravi DTO instancu
        $dto = new $dtoClass();
        foreach ($filteredData as $key => $value) {
            $dto->$key = $value;
        }

        // Validacija
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
        
            $exception = new BadRequestHttpException('Validation failed');
            // dodaj property 'validations' direktno na objekt
            $exception->validations = $messages;
        
            throw $exception;
        }

        return $dto;
    }
}
