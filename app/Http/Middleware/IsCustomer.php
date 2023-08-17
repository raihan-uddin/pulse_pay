<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated &&  Check if the user's account type is "customer"
        if (auth()->check() && auth()->user()->account_type === 'user') {
            return $next($request);
        }
        $message = ['message' => 'Permission Denied'];

        // If the user is not a merchant, you can redirect or return an error response
        return response()->json($message, 401);
    }
}
