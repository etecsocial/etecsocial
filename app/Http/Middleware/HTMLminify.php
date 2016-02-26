<?php

namespace App\Http\Middleware;

use Closure;

class HTMLminify 
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
		$response = $next($request);
        $content = $response->getContent();

        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1');

        $buffer = preg_replace($search, $replace, $content);
        return $response->setContent($buffer);    
    }
}
