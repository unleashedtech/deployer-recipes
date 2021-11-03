<?php

/**
 * Initialize shared_files variable.
 *
 * Some Drupal applications support multiple sites. To help streamline Deployer
 * configuration, the main Deployer Drupal config defines the `sites` variable
 * which is merely an array of machine names for the set of Drupal sites. The
 * default value for the `sites` variable is an array with one value: `default`.
 * This recipe loops through the `sites` variable & configures shared
 * files for each site based on the value of the `shared_file_names` variable.
 *
 * The `shared_files` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('platform:drupal:init:shared:files', static function (): void {
    $appDir      = get('app_directory_name');
    $sharedFiles = [];
    foreach (get('sites') as $site) {
        foreach (get('shared_file_names') as $sharedFileName) {
            $sharedFiles[] = $appDir . '/sites/' . $site . '/' . $sharedFileName;
        }
    }

    set('shared_files', $sharedFiles);
});
