<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes;

use function Deployer\run;

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
            run(\sprintf('fin exec "%s"', $command));
        } elseif (\is_file('.ddev/config.yaml')) {
            run(\sprintf('ddev exec "%s"', $command));
        } else {
            throw new \UnexpectedValueException('Unsupported VM.');
        }
    }
}
