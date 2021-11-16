<?php

/**
 * Magento Deploy Assets
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:magento:deploy:assets',
    static function (): void {
        $timestamp = \time();
        within(
            '{{release_or_current_path}}',
            '{{mage}} setup:static-content:deploy --content-version=' . $timestamp . ' {{static_content_locales}}'
        );
    }
)->desc('Deploy assets')->once();
