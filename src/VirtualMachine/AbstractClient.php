<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

abstract class AbstractClient implements ClientInterface
{
    public function drush(string $arguments): void
    {
        $this->run('drush ' . $arguments);
    }
}
