<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class RefreshToken
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if($request->bearerToken() && !$request->is('api/check')){
			$token = PersonalAccessToken::findToken($request->bearerToken());
			if($token){
				$token->forceFill(['created_at' => now()])->save();
			}
		}
		return $next($request);
	}
}
