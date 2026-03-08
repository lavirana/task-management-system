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
        $workspaceId = $request->route('workspace_id') 
                   ?? $request->header('X-Workspace-ID') 
                   ?? 'DEFAULT-WS';
   
            $this->sessionContext->setActiveWorkspaceId($workspaceId);

        return $next($request);
    }
}
