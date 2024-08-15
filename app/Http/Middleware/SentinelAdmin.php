<?php


namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SentinelAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Sentinel::check()) {
            return redirect('/')->with('error', 'You must be logged in!');
        }

        $user = Sentinel::getUser();
        if ($user->inRole('admin')) {
            if ($request->is('admin/*')) {
                return $next($request);
            }
            return redirect('/admin/dashboard');
        } elseif ($user->inRole('customer')) {
            if ($request->is('customer/*')) {
                return $next($request);
            }
            return redirect('/customer/dashboard');
        } elseif ($user->inRole('accountant')) {
            if ($request->is('accountant/*')) {
                return $next($request);
            }
            return redirect('/accountant/dashboard');
        }
        return $next($request);
    }

}
