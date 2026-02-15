<?php

declare(strict_types=1);

namespace Semitexa\Core\Contract;

/**
 * Contract for request handlers. Implement this and use #[AsServiceContract(of: HandlerInterface::class)]
 * so the handler is registered in the DI container.
 */
interface HandlerInterface
{
    public function handle(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
