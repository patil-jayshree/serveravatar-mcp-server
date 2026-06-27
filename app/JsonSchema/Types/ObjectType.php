<?php

namespace App\JsonSchema\Types;

use Illuminate\JsonSchema\Types\ObjectType as BaseObjectType;
use Illuminate\JsonSchema\Serializer;

/**
 * Custom ObjectType that uses App\JsonSchema\Serializer for proper inputSecret support.
 */
class ObjectType extends BaseObjectType
{
    /**
     * Convert the type to an array using our custom Serializer.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return \App\JsonSchema\Serializer::serialize($this);
    }
}
