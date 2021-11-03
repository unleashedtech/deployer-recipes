<?php

/**
 * Create a Wordpress database backup.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'platform:wp:db:backup:create',
    static function (): void {
        // Ensure that the backup directory exists.
        run('mkdir -p {{backups}}');

        // Make sure we have a current otherwise pass
        $exists = test('[ -d {{current_path}} ]');
        if (! $exists) {
            // pass - don't need to do backup if it's the first time
            return;
        }

        within(
            get('app_path'),
            static function (): void {
                $date     = \date('Y-m-d--H-i-s');
                $filename = '{{hostname}}--' . $date . '.sql';
                run('{{wp}} db export {{backups}}/' . $filename . ' --add-drop-table', ['timeout' => 60 * 20]);
            }
        );
    }
)->desc('Create a database backup file and gzip it.')->once();
