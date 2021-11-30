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
    if (! $exists) {
        // Pass. Don't need to do backup if it's the first time.
        return;
    }

    // Create the backup file.
    within(get('app_path'), static function (): void {
        $date = \date('Y-m-d--H-i-s');
        foreach (get('sites') as $site) {
            run(vsprintf('{{drush}} sql:dump @%s --gzip --result-file={{backups}}/%s', [
                $site,
                '{{namespace}}--' . $site . '-' . $date . '.sql'
            ]), ['timeout' => null]);
        }
    });
})->desc('Create a database backup files.')->once();
