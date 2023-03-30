<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)           //: Response
    {
        try {
            $jwt = $request->bearerToken(); //ambil token

            // dd(JWT::decode());            
            $decoded = JWT::decode($jwt,new Key(env('JWT_SECRET_KEY'),'HS256'));  //decode token

            //kondisi jika role pada token adalah admin, maka lanjut ke proses selanjutnya
            if($decoded->role == 'admin') {
                return $next($request);
            } else {
                //jika bukan role admin
                return response()->json('Unauthorized',401);
            }

        } catch (ExpiredException $e) {
            //jika token expired
            return response()->json($e->getMessage(),400);

        }
    }
}
