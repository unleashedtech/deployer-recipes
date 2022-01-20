<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

interface ClientInterface
{
    public function run(string $command): void;

    public function drush(string $arguments): void;

    public function import(string $file): void;
}
