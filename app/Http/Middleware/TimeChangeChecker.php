<?php

namespace App\Http\Middleware;

use App\Models\Timer;
use Closure;

class TimeChangeChecker
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
        if (Timer::hasActiveContest())
            return redirect('home');
        return $next($request);
    }
}
