<?php

declare(strict_types=1);

namespace App\Modules\Auth\Middleware;

use App\Modules\Auth\Services\JwtGuard;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticateWithJwtToken
{
    /**
     * Create a new middleware instance.
     *
     * @param AuthFactory $auth
     * @return void
     */
    public function __construct(
        protected AuthFactory $auth
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @param string|null $field
     * @return mixed
     *
     * @throws UnauthorizedHttpException
     */
    public function handle($request, \Closure $next, $guard = null, $field = null)
    {
        /** @var JwtGuard $jwtGuard */
        $jwtGuard = $this->auth->guard('api');

        if (!$jwtGuard->isValidToken()) {
            throw new UnauthorizedHttpException('Jwt', 'Invalid token');
        }

        return $next($request);
    }
}
