<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        /**
         * @var User $user;
         */
        $user = $request->user();
        $company = $user->company;

        if ($company) {
            $request->attributes->add(['company_hash' => $company->hash]);
        } else {
            abort(404, 'Company not found');
        }

        return $next($request);
    }
}
