<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCompanyHashPrefix
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->route('company_hash');

        if (!$company)
        {
            abort(404, 'Company not found');
        }
        $request->attributes->add(['company_hash' => $company->hash]);
        app()->instance('company', $company);
        $request->route()->forgetParameter('company_hash');
        return $next($request);
    }
}
