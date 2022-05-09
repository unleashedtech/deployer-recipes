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

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:disable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing

    /**
     * @param string[] $options
     */
    public function run(string $command, array $options = [], int $timeout = null): string
    {
        if ($timeout === null) {
            $timeout = $this->getClientTimeout();
        }

        $command = \sprintf('fin exec "%s"', $command);

        return runLocally($command, $options, $timeout);
    }

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:enable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing

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
