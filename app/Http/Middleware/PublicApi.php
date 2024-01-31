<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PublicApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $authorizationHeader = $request->header('Authorization');
        // if ($authorizationHeader !== 'A6567B2FC2755BCB1DBA78CB3ED1F') {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        return $next($request);
    }
}
