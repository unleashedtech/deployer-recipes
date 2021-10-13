<?php

/**
 * Initialize shared_files variable.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:init:shared:files', static function (): void {
    $appDir      = get('app_directory_name');
    $sharedFiles = [];
    foreach (get('sites') as $site) {
        foreach (get('shared_file_names') as $sharedFileName) {
            $sharedFiles[] = $appDir . '/sites/' . $site . '/' . $sharedFileName;
        }
    }

    set('shared_files', $sharedFiles);
});
