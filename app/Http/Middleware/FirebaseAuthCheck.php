<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('firebase_uid')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
