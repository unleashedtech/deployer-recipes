<?php

declare(strict_types=1);

namespace Deployer;

use Deployer\Task\Context;

/**
 * Sets a config parameter to the given value if it is not already set.
 *
 * @param string $var
 *   The config parameter to conditionally set.
 * @param mixed  $defaultValue
 *   The config parameter value to conditionally set.
 */
function fill(string $var, mixed $defaultValue): void
{
    if (! has($var)) {
        set($var, $defaultValue);
    } else {
        $value = get($var);
        switch (\gettype($value)) {
            case 'array':
                if (! \count($value)) {
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

/**
 * Takes a backup of the current configuration as an array.
 *
 * @return string[]
 *   The backup configuration.
 *
 * @throws \Deployer\Exception\Exception
 */
function config_backup(): array
{
    static $config;
    if ($config === null) {
        $config = [];
        if (! Context::has()) {
            $configObject = clone Deployer::get()->config;
        } else {
            $configObject = clone Context::get()->getConfig();
        }

        foreach ($configObject->ownValues() as $key => $value) {
            if (! \is_object($value)) {
                $config[$key] = $value;
            }
        }
    }

    return $config;
}

/**
 * Merges any backed up configuration into the main configuration.
 * This is best used following the inclusion of contrib recipes that provide their
 * own configuration values.
 */
function config_backup_merge(): void
{
    $config = config_backup();
    foreach ($config as $key => $value) {
        set($key, $value);
    }
}
