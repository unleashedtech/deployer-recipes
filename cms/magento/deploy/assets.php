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
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                $timestamp = \time();
                run('{{mage}} setup:static-content:deploy -f --content-version=' . $timestamp . ' {{static_content_locales}}');
            }
        );
    }
)->desc('Deploy assets')->once();
