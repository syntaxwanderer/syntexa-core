<?php

declare(strict_types=1);

namespace Semitexa\Core\Attributes;

use Attribute;

/**
 * Declares that this class replaces the given implementation in the DI container.
 * Strict chain: you can only override the current head (the class that is currently bound to the contract).
 * If that class was already overridden by another module, you must pass that module's class here.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Overrides
{
    public function __construct(
        /** The implementation class that this class replaces (must be the current head of the chain) */
        public string $replaces
    ) {}
}
