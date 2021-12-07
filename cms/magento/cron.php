<?php

/**
 * Replace old magento cron with new one (in new release directory).
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:magento:cron',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('{{mage}} cron:install -f');
            }
        );
    }
)->desc('Force Install a new cron.')->once();
