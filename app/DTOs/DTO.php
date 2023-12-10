<?php
namespace App\DTOs;

class DTO {
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();

        $data = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $data[$propertyName] = $property->getValue($this);
        }

        return $data;
    }
}
