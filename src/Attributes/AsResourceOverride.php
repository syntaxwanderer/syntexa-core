<?php

declare(strict_types=1);

namespace Semitexa\Core\Attributes;

use Attribute;
use Semitexa\Core\Http\Response\ResponseFormat;

/**
 * Declares an override for an existing AsResource-decorated class.
 * Can replace the class and/or adjust render hints.
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AsResourceOverride
{
    public function __construct(
        public string $of,
        public ?string $handle = null,
        public ?ResponseFormat $format = null,
        public ?string $renderer = null,
        public ?array $context = null,
        public int $priority = 0
    ) {}
}
