<?php

namespace Modules\BackEnd\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Modules\BackEnd\Common\ResponseType;
use Closure;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {   
        try {
            return parent::handle($request, $next);
        } catch (\Exception $e) {
            $result['code'] = ResponseType::CSRF_MISMATCH;
            $result['msg'] = "登录Token过期";
            $result['data'] = [];
            return response()->json($result);
        }
    }
}
