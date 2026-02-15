<?php

declare(strict_types=1);

namespace Semitexa\Core\Container;

use Semitexa\Core\Cookie\CookieJarInterface;
use Semitexa\Core\Request;
use Semitexa\Core\Session\SessionInterface;

/**
 * Request-scoped values (Request, Session, CookieJar) supplied per request.
 * Not part of the DI dependency graph; injected into mutable instances after clone.
 */
final class RequestContext
{
    public function __construct(
        public readonly Request $request,
        public readonly SessionInterface $session,
        public readonly CookieJarInterface $cookieJar
    ) {}
}
