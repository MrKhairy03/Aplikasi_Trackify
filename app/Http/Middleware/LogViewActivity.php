<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ActivityLogger;

class LogViewActivity
{
    public function handle($request, Closure $next, string $page)
    {
        $response = $next($request);

        ActivityLogger::log('view_' . $page);

        return $response;
    }
}
