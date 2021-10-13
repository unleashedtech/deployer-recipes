<?php

/**
 * Initialize shared_dirs variable.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:init:shared:dirs', static function (): void {
    $appDir     = get('app_directory_name');
    $sharedDirs = [];
    foreach (get('sites') as $site) {
        foreach (get('shared_dir_names') as $sharedDirName) {
            $sharedDirs[] = $appDir . '/sites/' . $site . '/' . $sharedDirName;
        }
    }

    set('shared_dirs', $sharedDirs);
});
