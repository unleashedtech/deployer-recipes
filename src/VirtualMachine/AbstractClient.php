<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine;

use function Deployer\get;

abstract class AbstractClient implements ClientInterface
{
    /**
     * @var string
     *   The primary platform installed in the VM.
     */
    protected $platform;

    public function __construct($platform)
    {
        $this->platform = $platform;
    }

    public function drush(string $arguments, string $site = 'default'): string
    {
        return $this->run('vendor/bin/drush -l ' . $site . ' ' . $arguments);
    }

    public function getClientTimeout(int $default = 3600): int
    {
        return (int) get('vm_client_timeout', $default);
    }

    public function getPlatform(): string {
        return $this->platform;
    }
}
