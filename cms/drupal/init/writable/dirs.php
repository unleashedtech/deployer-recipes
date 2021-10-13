<?php

/**
 * Initialize writable_dirs variable.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:init:writable:dirs', static function (): void {
    $appDir       = get('app_directory_name');
    $writableDirs = [];
    foreach (get('sites') as $site) {
        foreach (get('writable_dir_names') as $writableDirName) {
            $writableDirs[] = $appDir . '/sites/' . $site . '/' . $writableDirName;
        }
    }

    set('writable_dirs', $writableDirs);
});
