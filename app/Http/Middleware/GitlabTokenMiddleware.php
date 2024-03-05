<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GitlabTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check for the presence of the header
        if (! $request->hasHeader('X-Gitlab-Token')) {
            return response()->json(['message' => 'Unauthorized: Missing Gitlab token'], 401);
        }

        // Get the header value and compare with config
        $token = $request->header('X-Gitlab-Token');
        if ($token !== config('services.gitlab.secret_token')) {
            return response()->json(['message' => 'Unauthorized: Invalid Gitlab token'], 401);
        }

        return $next($request);
    }
}
