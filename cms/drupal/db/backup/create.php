<?php

/**
 * Create a drupal database
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:db:backup:create', static function (): void {
    // Ensure that the backup directory exists.
    run('mkdir -p {{backups}}');

    // Make sure we have a current_path directory, otherwise pass.
    $exists = test('[ -d {{current_path}} ]');
    if (!$exists) {
        // Pass. Don't need to do backup if it's the first time.
        return;
    }

    // Create the backup files.
    $appPath = get('app_path');
    foreach (get('sites') as $site) {
        within($appPath . '/sites/' . $site, static function () use ($site): void {
            run(\vsprintf('{{drush}} sql:dump --gzip --result-file={{backups}}/{{namespace}}--%s-%s.sql', [
                $site,
                \date('Y-m-d--H-i-s'),
            ]));
        });
    }
})->desc('Create a database backup files.')->once();
