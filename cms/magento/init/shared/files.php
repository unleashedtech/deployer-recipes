<?php

/**
 * Initialize shared_files variable.
 *
 * Add the app_directory_name as a prefix to the shared_files array.
 *
 * The `shared_files` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:magento:init:shared:files', static function (): void {
    $appDir      = get('app_directory_name');
    $sharedFiles = [];
    foreach (get('shared_files') as $sharedFileName) {
        $sharedFiles[] = $appDir . '/' . $sharedFileName;
    }

    set('shared_files', $sharedFiles);
});
