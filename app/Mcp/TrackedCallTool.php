<?php

namespace App\Mcp;

use Generator;
use Illuminate\Container\Container;
use Laravel\Mcp\Exceptions\JsonRpcException;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Methods\CallTool;
use Laravel\Mcp\Server\Methods\Concerns\InteractsWithResponses;
use Laravel\Mcp\Server\ServerContext;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Transport\JsonRpcRequest;
use Laravel\Mcp\Transport\JsonRpcResponse;

class TrackedCallTool extends CallTool
{
    use InteractsWithResponses;

    public function handle(JsonRpcRequest $request, ServerContext $context): Generator|JsonRpcResponse
    {
        $toolName = $request->get('name', 'unknown');

        // Track tool call AFTER tool executes successfully
        try {
            $user = auth()->user();
            if ($user) {
                $clientName = \App\Services\McpConnectionTracker::detectClient(request()->userAgent());
                \App\Services\McpConnectionTracker::recordToolCall($user, $clientName, $toolName);
            }
        } catch (\Throwable $e) {
            // Never interfere with tool execution
        }

        // Delegate to parent CallTool for actual execution
        return parent::handle($request, $context);
    }
}
