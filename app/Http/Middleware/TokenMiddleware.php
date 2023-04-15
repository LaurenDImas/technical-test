<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedSecrets =  env('ALLOWED_SECRETS');
        $header         = $request->header('key');

        if(!$header){
            return response()->json([
                "error" => "API key is missing."
            ], 403);
        }

        if ($header !== $allowedSecrets) {
            return response()->json([
                "error" => "Invalid API key."
            ], 401);
        }

        return $next($request);
    }
}
