<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AuthorizationController as BaseAuthorizationController;
use Exception;

/**
 * OAuth Authorization Controller
 *
 * Handles OAuth authorization for MCP clients. This controller extends
 * Laravel Passport's base authorization controller to customize the
 * authorization flow for ServerAvatar MCP clients.
 *
 * MCP OAuth Flow:
 * 1. User visits authorization URL
 * 2. Custom form is shown (if not authenticated)
 * 3. After user approves, they are redirected here
 * 4. This controller automatically approves the request
 */
class OAuthAuthorizeController extends BaseAuthorizationController
{
    /**
     * Authorize an OAuth client request.
     *
     * @param Request $request The incoming HTTP request
     * @param callable|null $nextAuthDecision
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function authorize(Request $request, callable $nextAuthDecision = null)
    {
        try {
            $request->merge(['approve' => true]);
            return parent::authorize($request, $nextAuthDecision);
        } catch (Exception $e) {
            return redirect('/')->with('error', 'OAuth authorization failed. Please try again.');
        }
    }
}
