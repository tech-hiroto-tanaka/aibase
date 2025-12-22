<?php

namespace App\Http\Middleware;

use App\Enums\StatusCode;
use Closure;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class User
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('user')->check()) {
            if($request->ajax())
            {
                return response()->json([
                    'status' => StatusCode::UNAUTHORIZED
                ], StatusCode::OK);
            }
            return redirect(route('login.index', ['url_redirect' => url()->full()]));
        }
        return $next($request);
    }
}
