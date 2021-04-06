<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response=[];
        $response["message"] = "Unauthorized!";
        $response["code"] = 401;

        if($request->user()) {
            if($request->user()["usertype"] == "admin") {
                    return $next($request);
            }
            $response["message"] = "Forbbiden!";
            $response["code"] = 403;
         }
         return response($response, $response["code"]);
    }
}
