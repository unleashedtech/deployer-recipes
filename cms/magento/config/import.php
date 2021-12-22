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
        $configImportNeeded = false;
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
                    run('{{mage}} app:config:status');
                }
            );
        } catch (RunException $e) {
            if ($e->getExitCode() == 2) {
                $configImportNeeded = true;
            } else {
                throw $e;
            }
        }

        if ($configImportNeeded) {
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                function () {
                    run('{{mage}} app:config:import --no-interaction');
                }
            );
        }
    }
)->desc('Import Configuration.')->once();
