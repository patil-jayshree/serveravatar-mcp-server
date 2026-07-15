<?php

namespace App\JsonSchema;

use Closure;
use App\JsonSchema\JsonSchemaTypeFactory;

/**
 * Extended JsonSchema with MCP support.
 * 
 * @method static \Illuminate\JsonSchema\Types\ObjectType object(Closure|array<string, \Illuminate\JsonSchema\Types\Type> $properties = [])
 * @method static \Illuminate\JsonSchema\Types\IntegerType integer()
 * @method static \Illuminate\JsonSchema\Types\NumberType number()
 * @method static \Illuminate\JsonSchema\Types\StringType string()
 * @method static \Illuminate\JsonSchema\Types\BooleanType boolean()
 * @method static \Illuminate\JsonSchema\Types\ArrayType array()
 * @method static \Illuminate\JsonSchema\Types\UnionType union(array<int, string> $types)
 */
class JsonSchema extends \Illuminate\JsonSchema\JsonSchema
{
    /**
     * Build a type from a raw array of the Laravel-supported JSON Schema subset.
     *
     * @param  array<string, mixed>  $schema
     *
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $schema): \Illuminate\JsonSchema\Types\Type
    {
        return parent::fromArray($schema);
    }

    /**
     * Dynamically pass static methods to the schema instance.
     */
    public static function __callStatic(string $name, mixed $arguments): \Illuminate\JsonSchema\Types\Type
    {
        return (new JsonSchemaTypeFactory)->$name(...$arguments);
    }
}
