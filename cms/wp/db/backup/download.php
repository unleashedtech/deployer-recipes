<?php

/**
 * Download the latest database backup file.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:wp:db:backup:download', static function (): void {
    $latestBackup = run('\ls -rt -1 {{backups}} | tail -1');
    runLocally('mkdir -p {{local_backups}}');
    download('{{backups}}/' . $latestBackup, '{{local_backups}}/');
})->desc('Download the latest database backup.')->once();
