<?php

declare(strict_types=1);

namespace Semitexa\Core\Container;

use Semitexa\Core\Contract\ContractFactoryInterface;

/**
 * Generic factory for a contract: getDefault(), get(string $key), keys().
 * Used instead of generated per-contract factory classes. The container binds
 * each Factory* interface to an instance of this class configured for that contract.
 */
final class ContractFactory implements ContractFactoryInterface
{
    /** @var object */
    private object $default;

    /** @var array<string, object> */
    private array $byKey;

    /**
     * @param object $default Active implementation (by module order or resolver).
     * @param array<string, object> $byKey Key => implementation (e.g. Module::ShortClassName).
     */
    public function __construct(object $default, array $byKey)
    {
        $this->default = $default;
        $this->byKey = $byKey;
    }

    public function getDefault(): object
    {
        return $this->default;
    }

    public function get(string $key): object
    {
        $keyLower = strtolower($key);
        foreach ($this->byKey as $k => $impl) {
            if (strtolower($k) === $keyLower) {
                return $impl;
            }
        }
        throw new \InvalidArgumentException(
            'Unknown implementation key: ' . $key . '. Available: ' . implode(', ', array_keys($this->byKey))
        );
    }

    /** @return list<string> */
    public function keys(): array
    {
        return array_keys($this->byKey);
    }
}
