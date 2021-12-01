<?php

/**
 * Initialize writable_dirs variable.
 *
 * Add the app_directory_name as a prefix to the writable_dirs array.
 *
 * The `writable_dirs` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:magento:init:writable:dirs', static function (): void {
    $appDir       = get('app_directory_name');
    $writableDirs = [];
    foreach (get('writable_dir_names') as $writableDirName) {
        $writableDirs[] = $appDir . '/' . $writableDirName;
    }

    set('writable_dirs', $writableDirs);
});
