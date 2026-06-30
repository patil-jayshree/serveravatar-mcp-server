<?php

namespace App\JsonSchema\Types;

use Illuminate\JsonSchema\Types\StringType;

/**
 * SecretType represents a sensitive string field (password, secret, etc.).
 *
 * This type extends StringType but marks the field as sensitive.
 * Outputs "string" type with format "inputSecret" for MCP spec compliance.
 */
class SecretType extends StringType
{
    /**
     * The secret type identifier for potential future use.
     */
    protected string $mcpType = 'secret';

    /**
     * Create a new SecretType instance.
     */
    public function __construct()
    {
        // Set format on the object so Serializer::get_object_vars() sees it
        $this->format = 'inputSecret';
    }

    /**
     * Convert the type to an array.
     * Outputs "string" type with format "inputSecret" for MCP spec.
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

        // Only filter out nullable from JSON Schema output
        $ignore = ['nullable', 'mcpType'];
        $attributes = array_filter($attributes, static function (mixed $value, string $key) use ($ignore) {
            if (in_array($key, $ignore, true)) {
                return false;
            }
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        return $attributes;
    }
}
