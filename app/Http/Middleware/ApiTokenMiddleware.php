<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Traits\Helper;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    use Helper;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $postToken = $request->bearerToken();
        // token static
        // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoibmFrZWRwcmVzcy10b2tlbiJ9.wcg0hI7WiNuZAbAGb9-D4z2IkYlz75__sTWenBZL17w
        $decodeToken = $this->decodeToken($postToken);
        if (!$decodeToken) {
            return response(['message' => 'Token is invalid'], 403);
        }
        // $find = ApiToken::where('sort_token', $postToken)->first();
        // if (!$find) {
        //     return response(['message' => 'Token is invalid'], 403);
        // }
        return $next($request);
    }
}
