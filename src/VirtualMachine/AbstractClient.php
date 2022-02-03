<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

use function Deployer\get;

abstract class AbstractClient implements ClientInterface
{
    public function drush(string $arguments): string
    {
        return $this->run('drush ' . $arguments);
    }

    public function getClientTimeout(int $default = 3600): int
    {
        return (int) get('vm_client_timeout', $default);
    }
}
