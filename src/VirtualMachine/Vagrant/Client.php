<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Vagrant;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function getName(): string {
        return 'vagrant';
    }

    public function run(string $command): string
    {
        return runLocally(\sprintf('vagrant ssh -c "%s"', $command));
    }

    public function import(string $file): string
    {
        // TODO: Implement import() method.
        throw new \BadMethodCallException();
    }
}
