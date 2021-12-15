<?php

/**
 * Create a Magento Database Backup
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Exception\RunException;

/**
 *   Database backup attempt.  It's only an attempt because we don't want to
 *   block a deploy if the backup fails.
 *
 */
task(
    'cms:magento:db:backup:create',
    function () {
        // Make sure we have a current_path directory, otherwise pass.
        $exists = test('[ -d {{current_path}} ]');
        if (!$exists) {
            // Pass. Don't need to do backup if it's the first time.
            return;
        }
        try {
            within(
                get('app_path'),
                function () {
                    run('{{mage}} setup:db:status');
                }
            );
        } catch (RunException $e) {
            if ($e->getExitCode() == 2) {
                return;
            }
        }

        try {
            within(
                get('app_path'),
                function () {
                    run('{{mage}} config:set system/backup/functionality_enabled 1');
                }
            );
        } catch (RunException $e) {
            return;
        }

        // Create the backup file.
        within(
            get('app_path'),
            function () {
                run('{{mage}} setup:backup --db', ['timeout' => null]);
                run('{{mage}} info:backups:list');
            }
        );
    }
)->desc('Create a database backup file.')->once();
