<?php

namespace App\Http\Middleware;

use App\Enums\UserTypeEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class Type
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {

        if (!Auth::check())
            return response(view('main.unauthorized'));

        $user = Auth::user();
        if ($type != null && $user->type === UserTypeEnum::getValue($type))
            return $next($request);

        return response(view('main.unauthorized'));
    }
}
