<?php

declare(strict_types=1);

namespace Semitexa\Core\Event;

/**
 * Contract for event dispatch. Implementations are registered via #[AsServiceContract(of: EventDispatcherInterface::class)].
 */
interface EventDispatcherInterface
{
    /**
     * Create an event instance from class and payload.
     */
    public function create(string $eventClass, array $payload): object;

    /**
     * Dispatch event to all registered listeners (sync / async / queued by listener config).
     */
    public function dispatch(object $event): void;
}
