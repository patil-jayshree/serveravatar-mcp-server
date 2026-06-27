<?php

namespace App\JsonSchema;

use Illuminate\JsonSchema\JsonSchemaTypeFactory as BaseFactory;
use Illuminate\JsonSchema\Types\Type;
use App\JsonSchema\Types\SecretType;
use App\JsonSchema\Types\ObjectType;
use Closure;

/**
 * Extended JsonSchemaTypeFactory that adds the secret() method for inputSecret type
 * and uses our custom ObjectType.
 */
class JsonSchemaTypeFactory extends BaseFactory
{
    /**
     * Create a new object schema instance.
     *
     * @param  (Closure(JsonSchemaTypeFactory): array<string, Types\Type>)|array<string, Types\Type>  $properties
     */
    public function object(Closure|array $properties = []): ObjectType
    {
        if ($properties instanceof Closure) {
            $properties = $properties($this);
        }

        return new ObjectType($properties);
    }

    /**
     * Create a new secret (inputSecret) type instance.
     *
     * @return SecretType
     */
    public function secret(): SecretType
    {
        return new SecretType();
    }
}
