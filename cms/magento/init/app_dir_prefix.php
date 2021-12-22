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

task('cms:magento:init', static function (): void {
    $vars = ['shared_dirs', 'shared_files', 'writable_dirs', 'clear_paths'];
    $appDir = get('app_directory_name');

    foreach ($vars as $var) {
        $newVars = [];
        foreach (get($var) as $file_dir) {
            $newVars[] = $appDir . '/' . $file_dir;
        }
        set($var, $newVars);
    }
    invoke("deploy:unlock");
});
