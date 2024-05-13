<?php

declare(strict_types=1);

namespace BotAcademy\Core\Http\Middleware;

use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/vnd.api+json');
        return $next($request);
    }
}
