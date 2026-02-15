<?php

declare(strict_types=1);

namespace Semitexa\Core\Event;

/**
 * Contract for event listeners. Implementations are discovered via #[AsEventListener(event: ...)]
 * and must be registered in the container via #[AsServiceContract(of: EventListenerInterface::class)].
 */
interface EventListenerInterface
{
    public function handle(object $event): void;
}
