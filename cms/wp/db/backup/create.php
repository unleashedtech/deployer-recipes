<?php

/**
 * Create a Wordpress database backup.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:wp:db:backup:create',
    static function (): void {
        // Ensure that the backup directory exists.
        run('mkdir -p {{backups}}');

        within(
            get('repo'),
            static function (): void {
                $date     = \date('Y-m-d--H-i-s');
                $filename = '{{hostname}}--' . $date . '.sql';
                run('{{wp}} db export {{backups}}/' . $filename . ' --add-drop-table', ['timeout' => 60 * 20]);
            }
        );
    }
)->desc('Create a database backup file and gzip it.')->once();
