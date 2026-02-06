<?php

declare(strict_types=1);

namespace Semitexa\Core\Attributes;

use Attribute;

/**
 * Marks a trait as an extension part of a resource (response) DTO.
 *
 * Modules can provide resource parts that will be combined into the final
 * project-specific resource class during code generation.
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AsResourcePart
{
    public function __construct(
        /**
         * Fully-qualified class name of the base resource that this part targets.
         */
        public string $base
    ) {
    }
}
