<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Ddev;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function run(string $command): void
    {
        runLocally(\sprintf('ddev exec "%s"', $command));
    }

    public function import(string $file): void
    {
        // TODO: Implement import() method.
        throw new \BadMethodCallException();
    }
}
