<?php

namespace App\JsonSchema\Types;

use Illuminate\JsonSchema\Types\StringType;

/**
 * SecretType represents a sensitive string field (password, secret, etc.).
 * 
 * This type extends StringType but marks the field as sensitive.
 * Currently outputs as "string" type for JSON Schema compliance,
 * but the SecretType class is available for future UI/hint differentiation.
 */
class SecretType extends StringType
{
    /**
     * The secret type identifier for potential future use.
     */
    protected string $mcpType = 'secret';

    /**
     * Convert the type to an array.
     * Outputs "string" type for JSON Schema compliance with MCP spec.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        // Get all properties from parent
        $attributes = (fn () => get_object_vars($this))->call($this);
        
        // Set type to string (JSON Schema compliant)
        $attributes['type'] = 'string';
        
        // Remove internal properties
        unset($attributes['mcpType']);
        
        // Filter out null values and ignored properties
        $ignore = ['required', 'nullable', 'mcpType'];
        $attributes = array_filter($attributes, static function (mixed $value, string $key) use ($ignore) {
            if (in_array($key, $ignore, true)) {
                return false;
            }
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);
        
        return $attributes;
    }
}