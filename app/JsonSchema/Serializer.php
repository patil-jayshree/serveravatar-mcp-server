<?php

namespace App\JsonSchema;

use Illuminate\JsonSchema\Serializer as BaseSerializer;
use Illuminate\JsonSchema\Types\Type;
use App\JsonSchema\Types\SecretType;
use App\JsonSchema\Types\ObjectType;
use App\JsonSchema\Types\ArrayType;
use App\JsonSchema\Types\IntegerType;
use App\JsonSchema\Types\NumberType;
use App\JsonSchema\Types\StringType;
use App\JsonSchema\Types\BooleanType;
use App\JsonSchema\Types\UnionType;

/**
 * Custom Serializer that handles MCP inputSecret type and custom ObjectType.
 */
class Serializer extends BaseSerializer
{
    /**
     * Serialize the given property to an array.
     *
     * @return array<string, mixed>
     */
    public static function serialize(Type $type): array
    {
        // Handle our custom SecretType - output as string for JSON Schema compliance
        if ($type instanceof SecretType) {
            $attributes = (fn () => get_object_vars($type))->call($type);
            $attributes['type'] = 'string'; // JSON Schema compliant
            
            // Remove internal properties not part of JSON Schema
            unset($attributes['mcpType']);
            
            $attributes = array_filter($attributes, static function (mixed $value, string $key) {
                if (in_array($key, static::$ignore, true)) {
                    return false;
                }
                return $value !== null;
            }, ARRAY_FILTER_USE_BOTH);
            
            return $attributes;
        }
        
        // Handle our custom ObjectType
        if ($type instanceof ObjectType) {
            return static::serializeObjectType($type);
        }
        
        // Fall back to parent serializer for standard Laravel types
        return parent::serialize($type);
    }
    
    /**
     * Serialize an ObjectType with proper handling of SecretType.
     *
     * @return array<string, mixed>
     */
    protected static function serializeObjectType(ObjectType $type): array
    {
        $attributes = (fn () => get_object_vars($type))->call($type);
        $attributes['type'] = 'object';
        
        if (count($attributes['properties']) === 0) {
            unset($attributes['properties']);
        } else {
            // Use custom isRequired check that handles PHP's get_object_vars() converting true to 1
            $required = array_map(
                'strval',
                array_keys(array_filter(
                    $attributes['properties'],
                    static fn (Type $property) => static::checkRequired($property),
                ))
            );
            
            if ($required !== []) {
                $attributes['required'] = $required;
            }
            
            // Use OUR serialize method (recursive) instead of parent's
            $attributes['properties'] = array_map(
                static fn (Type $property) => static::serialize($property),
                $attributes['properties'],
            );
        }
        
        // Filter out null values and ignored properties (but keep 'required' for ObjectType)
        $attributes = array_filter($attributes, static function (mixed $value, string $key) {
            // 'required' should be kept if it's a non-empty array
            if ($key === 'required') {
                return !empty($value);
            }
            if (in_array($key, static::$ignore, true)) {
                return false;
            }
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);
        
        error_log('serializeObjectType: final attributes keys = ' . json_encode(array_keys($attributes)));
        
        return $attributes;
    }
    
    /**
     * Check if a type is required.
     * Overrides parent to handle PHP's get_object_vars() converting boolean true to integer 1.
     */
    protected static function checkRequired(Type $type): bool
    {
        $attributes = (fn () => get_object_vars($type))->call($type);

        // Handle both boolean true and integer 1 (PHP quirk with get_object_vars)
        return isset($attributes['required']) && ($attributes['required'] === true || $attributes['required'] === 1);
    }
}
