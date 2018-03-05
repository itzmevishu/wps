<?php
/**
 * Created by PhpStorm.
 * User: irodela
 * Date: 7/1/2016
 * Time: 7:49 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class Impersonate {
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('impersonate'))
        {
            Auth::onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}