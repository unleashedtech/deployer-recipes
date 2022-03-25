<?php

/**
 * Rebuilds the caches for the Drupal database(s).
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:cache:rebuild', static function (): void {
    if (get('skip_db_ops') || get('skip_cache_rebuild')) {
        return;
    }

    $appPath = get('app_path');
    $sites   = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        within($appPath . '/sites/' . $site, static function (): void {
            run('{{drush}} cr');
        });
    }
})->desc('Rebuilds Drupal caches.');
