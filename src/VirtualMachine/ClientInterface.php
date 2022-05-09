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

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:disable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing

    /**
     * @param string[] $options
     */
    public function run(string $command, array $options = [], int $timeout = null): string;

    // @todo remove the following phpcs directive once PHP 7.3 is no longer supported
    // phpcs:enable SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilityTypeMissing
}
