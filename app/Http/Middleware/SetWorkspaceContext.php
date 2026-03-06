<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Contexts\SessionContext;

class SetWorkspaceContext
{
    public function __construct(protected SessionContext $sessionContext)
    {
        $this->sessionContext = $sessionContext;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workspaceId = $request->header('X-Workspace-ID') ?? $request->header('TEST-123');
        if ($workspaceId) {
            $this->sessionContext->setActiveWorkspace($workspaceId);
        }
        return $next($request);
    }
}
