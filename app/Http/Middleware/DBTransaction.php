<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class DBTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        DB::beginTransaction();
        try {
            $response = $next($request);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        if ($response->getStatusCode() > 399) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $next($request);
    }
}
