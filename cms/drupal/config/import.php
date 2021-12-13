<?php

/**
 * Imports config to the Drupal database(s).
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:config:import', static function (): void {
    if (get('skip_db_ops') || get('skip_config_import')) {
        return;
    }

    $appPath = get('app_path');
    foreach (get('sites') as $site) {
        within($appPath . '/sites/' . $site, static function (): void {
            run('{{drush}} config:import -y');
        });
    }
})->desc('Imports config into Drupal from code in the repo.');
