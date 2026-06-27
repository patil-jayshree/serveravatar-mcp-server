<?php

namespace App\Mcp\Tools;

use App\JsonSchema\JsonSchema as AppJsonSchema;
use Illuminate\Container\Container;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Server\Tool as LaravelTool;
use Laravel\Mcp\Server\Attributes\RendersApp;
use Laravel\Mcp\Server\Concerns\HasAnnotations;
use Laravel\Mcp\Server\Tools\Annotations\ToolAnnotation;
use Laravel\Mcp\Server\Ui\Enums\Visibility;

/**
 * Custom base Tool class that uses App\JsonSchema for proper inputSecret support.
 */
abstract class Tool extends LaravelTool
{
    use HasAnnotations;

    /**
     * @return array<string, mixed>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }

    /**
     * Define the output schema for this tool's results.
     *
     * @return array<string, mixed>
     */
    public function outputSchema(JsonSchema $schema): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function toMethodCall(): array
    {
        return ['name' => $this->name()];
    }

    /**
     * Get the tool's array representation.
     * Uses App\JsonSchema instead of Illuminate\JsonSchema for inputSecret support.
     *
     * @return array{
     *     name: string,
     *     title?: string|null,
     *     description?: string|null,
     *     inputSchema?: array<string, mixed>,
     *     outputSchema?: array<string, mixed>,
     *     annotations?: array<string, mixed>|object,
     *     _meta?: array<string, mixed>
     * }
     */
    public function toArray(): array
    {
        $annotations = $this->annotations();

        // Use our custom JsonSchema which supports inputSecret
        $schema = AppJsonSchema::object(
            $this->schema(...),
        )->toArray();

        $outputSchema = AppJsonSchema::object(
            $this->outputSchema(...),
        )->toArray();

        $schema['properties'] ??= (object) [];

        $result = [
            'name' => $this->name(),
            'title' => $this->title(),
            'description' => $this->description(),
            'inputSchema' => $schema,
            'annotations' => $annotations === [] ? (object) [] : $annotations,
        ];

        if (isset($outputSchema['properties'])) {
            $result['outputSchema'] = $outputSchema;
        }

        $rendersApp = $this->resolveAttribute(RendersApp::class);

        if ($rendersApp !== null) {
            /** @var \Laravel\Mcp\Server\AppResource $appResource */
            $appResource = Container::getInstance()->make($rendersApp->resource);

            $this->setMeta('ui', [
                'resourceUri' => $appResource->uri(),
                'visibility' => array_map(fn (Visibility $visiblity) => $visiblity->value, $rendersApp->visibility),
            ]);
        }

        // @phpstan-ignore return.type
        return $this->mergeMeta($this->mergeIcons($result));
    }
}
