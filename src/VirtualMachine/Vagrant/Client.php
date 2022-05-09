<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Vagrant;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function getName(): string
    {
        return 'vagrant';
    }

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:disable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing

    /**
     * @param string[] $options
     */
    public function run(string $command, array $options = [], int $timeout = null): string
    {
        return runLocally(\sprintf('vagrant ssh -c "%s"', $command));
    }

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:enable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing

    public function import(string $file): string
    {
        // TODO: Implement import() method.
        throw new \BadMethodCallException();
    }
}
