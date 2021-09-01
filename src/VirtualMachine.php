<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes;

/**
 * @internal
 *
 * TODO: Define a `localhost` host that tells Deployer how to connect to the VM, so any task can be run within the VM.
 *       This may mean the web container needs to be configured to provide standard-fare SSH connectivity.
 */
class VirtualMachine
{
    public static function run(string $command): void
    {
        if (\is_file('.docksal/docksal.yml')) {
            \Deployer\run(\sprintf('fin exec "%s"', $command));
        } elseif (\is_file('.ddev/config.yaml')) {
            \Deployer\run(\sprintf('ddev exec "%s"', $command));
        } else {
            throw new \UnexpectedValueException('Unsupported VM.');
        }
    }

}
