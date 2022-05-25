<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

// TODO: use PSR-4 autoloading here
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/ClientInterface.php';
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/AbstractClient.php';

use UnexpectedValueException;

class VirtualMachine
{
    /**
     * Load the VirtualMachine object.
     *
     * @param string $platform
     *   Returned platform to use.
     */
    public static function load(string $platform): ClientInterface
    {
        if (\is_file('.ddev/config.yaml')) {
            // TODO: use PSR-4 autoloading here with aliased class name
            require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/Ddev/Client.php';

            return new Ddev\Client($platform);
        }

        if (\is_file('.docksal/docksal.yml')) {
            // TODO: use PSR-4 autoloading here with aliased class name
            require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/Docksal/Client.php';

            return new Docksal\Client($platform);
        }

        if (\is_file('Vagrantfile')) {
            // TODO: use PSR-4 autoloading here with aliased class name
            require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/Vagrant/Client.php';

            return new Vagrant\Client($platform);
        }

        throw new UnexpectedValueException('Unsupported VM.');
    }

    /**
     * Return the names of the platforms.
     *
     * @return string[]
     *   Supported platforms.
     */
    public static function getNames(): array
    {
        return [
            'ddev',
            'docksal',
            'vagrant',
        ];
    }
}
