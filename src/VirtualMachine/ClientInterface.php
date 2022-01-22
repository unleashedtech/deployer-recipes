<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

interface ClientInterface
{
    public function run(string $command): string;

    public function drush(string $arguments): string;

    public function import(string $file): string;
}
