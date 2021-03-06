<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

interface ClientInterface
{
    public function drush(string $arguments, string $site = 'default'): string;

    public function getName(): string;

    public function getPlatform(): string;

    public function getClientTimeout(int $default = 3600): int;

    public function import(string $file): string;

    public function run(string $command): string;
}
