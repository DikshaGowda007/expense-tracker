<?php

namespace App\Http\Middleware;

use App\Constants\CommonConstant;
use App\Modules\Auth\JwtService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VerifyJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request
        ->cookie('token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => CommonConstant::TOKEN_NOT_PROVIDED], CommonConstant::UNAUTHORIZED_EXCEPTION_CODE);
        }
        try {
            $decoded = JwtService::decodeToken($token);
            if (!$decoded) {
                return response()->json(['status' => 'error', 'message' => CommonConstant::UNAUTHORIZED_EXCEPTION_MESSAGE], CommonConstant::UNAUTHORIZED_EXCEPTION_CODE);
            }
            if (!is_null($decoded) && is_array($decoded)) {
                $request->merge(['jwtUser' => $decoded]);
            }
        } catch (Throwable | Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
        return $next($request);
    }
}
