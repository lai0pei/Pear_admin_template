<?php

namespace Modules\BackEnd\Http\Middleware;

use Illuminate\Session\Middleware\AuthenticateSession;
use Closure;

class Session extends AuthenticateSession{


      /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       return parent::handle($request,$next);
    }

}