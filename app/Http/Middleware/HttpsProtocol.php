<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
	$request->setTrustedProxies([ $request->getClientIp()]);

        if (!$request->secure() and ( $_SERVER['HTTP_HOST'] != "etecsocial.com.br")) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
