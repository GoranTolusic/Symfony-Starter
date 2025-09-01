<?php

namespace App\Dto;

abstract class BaseAbstractDto
{
    final public function toEntity(object $entity)
    {
        $dtoValues = get_object_vars($this);
        $entityRef = new \ReflectionClass($entity);
        
        foreach ($dtoValues as $name => $value) {
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
