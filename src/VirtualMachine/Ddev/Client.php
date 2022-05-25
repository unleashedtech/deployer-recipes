<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Ddev;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function getName(): string
    {
        return 'ddev';
    }

    public function run(string $command): string
    {
        return runLocally(\sprintf('ddev exec "%s"', $command));
    }

    public function import(string $file): string
    {
        // TODO: Implement import() method.
        throw new \BadMethodCallException();
    }
}
