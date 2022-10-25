<?php

/**
 * Clear the Watchdog Log
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:watchdog:clear', static function (): void {
    $appPath = get('app_path');
    $sites   = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        within($appPath . '/sites/' . $site, static function (): void {
            run('{{drush}} wd-del all -y');
        });
    }
})->desc('Clear the watchdog log.')->once();
