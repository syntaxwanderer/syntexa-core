<?php

declare(strict_types=1);

namespace Semitexa\Core\Container;

use Semitexa\Core\Attributes\Overrides;
use Semitexa\Core\IntelligentAutoloader;

/**
 * Builds service override chain from project src.
 * Only the current chain head for each contract can be overridden; otherwise throws.
 */
final class ServiceOverrideRegistry
{
    /** @var array<string, string> contract (interface/class) => replacement class */
    private array $overrides = [];

    /**
     * @param array<string, string> $defaults contract (interface/class) => default implementation class
     */
    public function __construct(
        private string $projectRoot,
        private array $defaults
    ) {
        $this->buildChains();
    }

    /**
     * Returns contract => replacement class for contracts that have an override from project src.
     *
     * @return array<string, string>
     */
    public function getOverrides(): array
    {
        return $this->overrides;
    }

    private function buildChains(): void
    {
        IntelligentAutoloader::initialize();
        $classes = IntelligentAutoloader::findClassesWithAttribute(Overrides::class);

        $fromProjectSrc = [];
        $projectSrc = rtrim($this->projectRoot, '/') . '/src/';
        $packagesSemitexa = '/packages/semitexa/';

        foreach ($classes as $className) {
            try {
                $file = (new \ReflectionClass($className))->getFileName();
                if ($file === false) {
                    continue;
                }
                $file = str_replace('\\', '/', $file);
                if (!str_starts_with($file, $projectSrc)) {
                    continue;
                }
                if (str_contains($file, $packagesSemitexa)) {
                    continue;
                }
                $ref = new \ReflectionClass($className);
                $attrs = $ref->getAttributes(Overrides::class);
                if ($attrs === []) {
                    continue;
                }
                /** @var Overrides $attr */
                $attr = $attrs[0]->newInstance();
                $replaces = ltrim($attr->replaces, '\\');
                $fromProjectSrc[] = ['replaces' => $replaces, 'replacement' => $className];
            } catch (\Throwable $e) {
                continue;
            }
        }

        $heads = $this->defaults;
        $pending = $fromProjectSrc;
        $maxIterations = count($pending) + 1;
        $iterations = 0;
        while ($pending !== [] && $iterations < $maxIterations) {
            $iterations++;
            $applied = false;
            $nextPending = [];
            foreach ($pending as $item) {
                $replaces = $item['replaces'];
                $replacement = $item['replacement'];
                $contract = $this->findContractForHead($heads, $replaces);
                if ($contract === null) {
                    $nextPending[] = $item;
                    continue;
                }
                if ($heads[$contract] !== $replaces) {
                    $nextPending[] = $item;
                    continue;
                }
                $heads[$contract] = $replacement;
                $applied = true;
            }
            if (!$applied && $nextPending !== []) {
                $item = $nextPending[0];
                $replaces = $item['replaces'];
                $replacement = $item['replacement'];
                $contract = $this->findContractForHead($this->defaults, $replaces);
                $currentHead = $contract !== null ? $heads[$contract] : null;
                throw new \RuntimeException(
                    "Service override chain violation: {$replacement} declares Overrides({$replaces}::class), but the current head for this contract is " . ($currentHead ?? 'unknown') . ". " .
                    "You can only override the current head. Use Overrides(\\" . ($currentHead ?? $replaces) . "::class) to extend the chain."
                );
            }
            $pending = $nextPending;
        }

        foreach ($heads as $contract => $impl) {
            if (($this->defaults[$contract] ?? null) !== $impl) {
                $this->overrides[$contract] = $impl;
            }
        }
    }

    /** @param array<string, string> $heads */
    private function findContractForHead(array $heads, string $headClass): ?string
    {
        foreach ($heads as $contract => $impl) {
            if (ltrim($impl, '\\') === $headClass) {
                return $contract;
            }
        }
        return null;
    }
}
