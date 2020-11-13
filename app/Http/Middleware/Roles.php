<?php

namespace App\Http\Middleware;

use Closure;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard=null)
    {
      if (auth()->user()->role!=$guard) {
        return redirect()->back()->withErrors('Anda tidak memiliki izin akses!');
      }
      return $next($request);
    }
}
