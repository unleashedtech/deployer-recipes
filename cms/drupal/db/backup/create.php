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
    run('mkdir -p {{backups}}/latest');

  // Move files out of the "latest" backups folder.
    run('[ "$(ls -A {{backups}}/latest)" ] && mv -v {{backups}}/latest/* {{backups}} || echo "No backups found in latest folder."');

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
        run('{{drush}} rq && {{drush}} sql:dump --gzip --result-file={{backups}}/latest/' . $filename . "|| echo 'Database not available'", ['timeout' => null]);
    });
})->desc('Create a database backup files.')->once();
