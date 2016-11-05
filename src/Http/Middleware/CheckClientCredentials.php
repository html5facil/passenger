<?php

namespace Masdevs\Passanger\Http\Middleware;

use Closure;
use League\OAuth2\Server\ResourceServer;
use Illuminate\Auth\AuthenticationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class CheckClientCredentials
{
    /**
     * The Resource Server instance.
     *
     * @var ResourceServer
     */
    private $server;

    /**
     * Create a new middleware instance.
     *
     * @param  ResourceServer  $server
     * @return void
     */
    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $psr = (new DiactorosFactory)->createRequest($request);

        try{
            $this->server->validateAuthenticatedRequest($psr);
        } catch (OAuthServerException $e) {
            throw new AuthenticationException;
        }

        return $next($request);
    }
}
