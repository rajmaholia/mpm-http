<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\CSRFToken;

class VerifyCsrfToken
{
    public function handle($request, Closure $next)
    {
        if ($this->isReading($request) || $this->runningUnitTests()) {
            return $next($request);
        }

        if (! $this->tokensMatch($request)) {
            return response('Invalid token', 403);
        }

        return $next($request);
    }

    protected function isReading($request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    protected function runningUnitTests()
    {
        return isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'testing';
    }

    protected function tokensMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header, static::serialized());
        }

        return CSRFToken::tokenIsValid($token);
    }
}
