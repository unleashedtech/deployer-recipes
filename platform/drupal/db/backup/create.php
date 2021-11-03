<?php

/**
 * Create a drupal database
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('platform:drupal:db:backup:create', static function (): void {
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
        // TODO: support exporting all sites found in site aliases list.
        // $result = run("{{drush}} sa --format json");
        // if (empty($result)) {
        //   throw new \UnexpectedValueException('No site aliases found!');
        // }
        // $aliases = json_decode($result);
        //foreach ($aliases as $alias => $info) {}

        $filename = '{{namespace}}--' . $date . '.sql';
        run('{{drush}} sql:dump --gzip --result-file={{backups}}/' . $filename, ['timeout' => null]);
    });
})->desc('Create a database backup files.')->once();
