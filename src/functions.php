<?php

declare(strict_types=1);

namespace Deployer;

use Deployer\Task\Context;

// @todo remove the following phpcs directive once PHP 7.3 is no longer supported
// phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint

/**
 * Sets a config parameter to the given value if it is not already set.
 *
 * @param string          $var
 *   The config parameter to conditionally set.
 * @param string|string[] $defaultValue
 *   The config parameter value to conditionally set.
 */
function fill(string $var, $defaultValue): void
{
    if (! has($var)) {
        set($var, $defaultValue);
    } else {
        $definedValue = get($var);
        switch (\gettype($definedValue)) {
            case 'array':
                // Allow override of the defined array if empty.
                if (! \count($definedValue)) {
                    set($var, $defaultValue);
                }

                break;

            case 'string':
                // Allow override of the defined string if empty.
                if (\trim($definedValue) === '') {
                    set($var, $defaultValue);
                }

                break;

            case 'boolean':
            case 'int':
            case 'NULL':
                // Var already explicitly defined. Do nothing.
                break;

            default:
                throw new \DomainException('Unsupported type: ' . \gettype($definedValue));
        }
    }
}

// @todo remove the following phpcs directive once PHP 7.3 is no longer supported
// phpcs:enable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint

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
