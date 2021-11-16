<?php

/**
 * Create a Magento Database Backup
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:magento:db:backup:create',
    static function (): void {
        // Ensure that the backup directory exists.
        run('mkdir -p {{backups}}');

        // Make sure we have a current_path directory, otherwise pass.
        $exists = test('[ -d {{current_path}} ]');
        if (! $exists) {
            // Pass. Don't need to do backup if it's the first time.
            return;
        }

        // Create the backup file.
        within(
            get('app_path'),
            static function (): void {
                run('{{mage}} setup:backup --db', ['timeout' => null]);
                run('{{mage}} info:backups:list');
            }
        );
    }
)->desc('Create a database backup files.')->once();
