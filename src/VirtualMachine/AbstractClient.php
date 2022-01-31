<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

abstract class AbstractClient implements ClientInterface
{
    public function drush(string $arguments): string
    {
        return $this->run('drush ' . $arguments);
    }
}
