<?php

declare(strict_types=1);

namespace Deployer;

/**
 * Sets a config parameter to the given value if it is not already set.
 *
 * @param string $var
 *   The config parameter to conditionally set.
 * @param mixed  $defaultValue
 *   The config parameter value to conditionally set.
 */
function fill(string $var, $defaultValue): void
{
    if (! has($var)) {
        set($var, $defaultValue);
    } else {
        $value = get($var);
        switch (\gettype($value)) {
            case 'array':
                if (!count($value)) {
                    set($var, $defaultValue);
                }

                break;

            case 'string':
                if (\trim($value) === '') {
                    set($var, $defaultValue);
                }

                break;

            case 'boolean':
                break;

            default:
                throw new \DomainException('Unsupported type: ' . \gettype($value));
        }
    }
}
