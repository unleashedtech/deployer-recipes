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
                run('rm app/etc/env.php'); // Remove bogus env.php placed by compile.php - To get around default website not being set error
                run('ln -s ../../../shared/docroot/app/etc/env.php app/etc/env.php'); // Temp file placement for static-content command
                run('{{mage}} setup:static-content:deploy -f --content-version=' . $timestamp . ' {{static_content_locales}}');
            }
        );
    }
)->desc('Deploy assets')->once();
