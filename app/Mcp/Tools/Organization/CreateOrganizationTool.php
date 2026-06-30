<?php

namespace App\Mcp\Tools\Organization;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Create a new organization in ServerAvatar.')]
class CreateOrganizationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        if (!empty($validated['description'])) {
            $data['description'] = $validated['description'];
        }

        $result = $this->apiCall("/organizations", $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->description('Organization name')->required(),
            'description' => $schema->string()->description('Organization description'),
        ];
    }
}
