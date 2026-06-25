<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AuthorizationController as BaseAuthorizationController;

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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * @note This bypasses the standard Passport CSRF and approval prompts
     *       as the user has already authorized via our custom form.
     */
    public function authorize(Request $request, callable $nextAuthDecision = null)
    {
        // For MCP OAuth, always approve since user already authorized via our custom form
        // This sets the approve parameter that Passport checks
        $request->merge(['approve' => true]);

        return parent::authorize($request, $nextAuthDecision);
    }
}
