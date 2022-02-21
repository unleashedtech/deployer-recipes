<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Docksal;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function getName(): string
    {
        return 'docksal';
    }

    public function run(string $command, array|null $options = [], int|null $timeout = null): string
    {
        if ($timeout === null) {
            $timeout = $this->getClientTimeout();
        }

        $command = \sprintf('fin exec "%s"', $command);

        return runLocally($command, $options, $timeout);
    }

    public function import(string $file, string $site = 'default'): string
    {
        $platform = $this->getPlatform();
        switch ($platform) {
            case 'drupal':
                $this->drush('-l ' . $site . ' sql-drop -y');

                return $this->run('gunzip < ' . $file . ' | vendor/bin/drush -l ' . $site . ' sqlc');
            default:
                throw new \DomainException('Database import for ' . $platform . ' not supported yet.');
        }
    }
}
