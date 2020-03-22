<?php

namespace App\Http\Middleware;

use Closure;

class ApiPublica
{
                         
    public function handle($request, Closure $next)
    {
       

        return $next($request);
    }
}