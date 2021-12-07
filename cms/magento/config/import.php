<?php

/**
 * Import Magento Configuration
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Exception\RunException;

/**
 *  Database Configuration Import
 *
 */
task(
    'cms:magento:config:import',
    function () {
        // Make sure we have a current_path directory, otherwise pass.
        $exists = test('[ -d {{current_path}} ]');
        if (!$exists) {
            // Pass. Don't need to do backup if it's the first time.
            return;
        }
        try {
            // See if we can check the db status.
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                function () {
                    run('{{mage}} setup:db:status');
                }
            );
        } catch (RunException $e) {
            if ($e->getExitCode() == 2) {
                within(
                    '{{release_or_current_path}}/{{app_directory_name}}',
                    function () {
                        run('{{mage}} setup:upgrade');
                    }
                );
            }
        }

        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                invoke('cms:magento:maintenance:enable');
                run('{{mage}} app:config:import ');
                invoke('cms:magento:maintenance:disable');
            }
        );
    }
)->desc('Import Configuration.')->once();
