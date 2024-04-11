<?php

namespace App\Http\Middleware;

use Closure;

class AuthDeliveryAgentApiRoute
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
        if(!authUser('deliveryagentapi')){
            return response()->json([
                'toast' => __('Unauthorized access'),
                'status' => false
            ], 403);
        }

        return $next($request);
    }
}
