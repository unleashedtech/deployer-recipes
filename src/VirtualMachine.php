<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes;

use function Deployer\runLocally;

/**
 * @internal
 *
 * TODO: Define a `localhost` host that tells Deployer how to connect to the VM, so any task can be run within the VM.
 *       This may mean the web container needs to be configured to provide standard-fare SSH connectivity.
 */
class VirtualMachine
{
    public static function run(string $command): string
    {
        $returnValue = '';
        if (\is_file('.ddev/config.yaml')) {
            $returnValue = runLocally(\sprintf('ddev exec "%s"', $command));
        } elseif (\is_file('.docksal/docksal.yml')) {
            $returnValue = runLocally(\sprintf('fin exec "%s"', $command));
        } elseif (\is_file('Vagrantfile')) {
            $returnValue = runLocally(\sprintf('vagrant ssh -c "%s"', $command));
        } else {
            throw new \UnexpectedValueException('Unsupported VM.');
        }
        return $returnValue;
    }
}
