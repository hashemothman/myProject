<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => false, 'message' => 'INVALID_TOKEN']);
                }elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['status' => false, 'message' => 'EXPIRED_TOKEN']);
                }else {
                    return response()->json(['status' => false, 'message' => 'TOKEN_NOTFOUND']);
                }
            }
        }
        // if (!$user) {
        //     return response()->json(['success' => false, 'message' => trans('Unauthenticated')]);

        // }
        return $next($request);
    }
}
