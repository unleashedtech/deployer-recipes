<?php

/**
 * Initialize shared_dirs variable.
 *
 * All the directories are subdirectories of docroot
 * This task function simply adds the app_directory_name to be
 * the parent directory.
 *
 * The `shared_dirs` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:magento:init:shared:dirs', static function (): void {
    $appDir     = get('app_directory_name');
    $sharedDirs = [];
    foreach (get('shared_dirs') as $sharedDirName) {
        $sharedDirs[] = $appDir . '/' . $sharedDirName;
    }

    set('shared_dirs', $sharedDirs);
});
