<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RecordControl
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
        if (Auth::user()->is_admin)
            return $next($request);
        $record = $request->route('record');
        foreach ($record->teams as $team)
            if ($team->id == Auth::user()->id)
                return $next($request);
        return abort(403);
    }
}
