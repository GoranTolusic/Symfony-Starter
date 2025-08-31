<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseAbstractDto
{
    final public function toEntity(object $entity)
    {
        $dtoProps = (new \ReflectionClass($this))->getProperties();
        $entityRef = new \ReflectionClass($entity);

        foreach ($dtoProps as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            $value = $prop->getValue($this);

            if ($entityRef->hasProperty($name)) {
                $entityProp = $entityRef->getProperty($name);
                if (!$entityProp->isReadOnly()) {
                    $entityProp->setAccessible(true);
                    $entityProp->setValue($entity, $value);
                }
            }
        }

        return $entity;
    }
}
