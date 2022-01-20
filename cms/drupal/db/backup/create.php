<?php

/**
 * Create a drupal database
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:db:backup:create', static function (): void {
    if (get('skip_db_ops') || get('skip_db_backup')) {
        return;
    }

    // Ensure that the backup directory exists.
    run('mkdir -p {{backups}}');

    // Make sure we have a current_path directory, otherwise pass.
    $exists = test('[ -d {{current_path}} ]');
    if (! $exists) {
        // Pass. Don't need to do backup if it's the first time.
        return;
    }

    // Create the backup files.
    $appPath = get('app_path');
    foreach (get('sites') as $site) {
        within($appPath . '/sites/' . $site, static function () use ($site): void {
            // Global Transaction IDs will be excluded from the backup, by default.
            // https://dev.mysql.com/doc/refman/5.7/en/replication-gtids-failover.html#replication-gtids-failover-gtid-purged
            // https://stackoverflow.com/a/54450831
            // https://forums.mysql.com/read.php?177,675645,675684#msg-675684
            // https://github.com/drush-ops/drush/issues/4188#issuecomment-719644172
            run(\vsprintf('{{drush}} sql:dump --gzip --result-file={{backups}}/{{namespace}}--%s-%s.sql --extra-dump="--set-gtid-purged=%s"', [
                $site,
                \date('Y-m-d--H-i-s'),
                get('db_dump_gtid_purged', 'OFF'),
            ]));
        });
    }
})->desc('Create a database backup files.')->once();
