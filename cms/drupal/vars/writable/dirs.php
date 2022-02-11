<?php

/**
 * Initialize writable_dirs variable.
 *
 * Some Drupal applications support multiple sites. To help streamline Deployer
 * configuration, the main Deployer Drupal config defines the `sites` variable
 * which is merely an array of machine names for the set of Drupal sites. The
 * default value for the `sites` variable is an array with one value: `default`.
 * This recipe loops through the `sites` variable & configures writable
 * directories for each site based on the value of the `writable_dir_names`
 * variable.
 *
 * The `writable_dirs` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:vars:writable:dirs', static function (): void {
    $writableDirs = [];
    $sites = get('sites');
    if (!is_array($sites)) {
        $sites = explode(',', $sites);
    }
    foreach ($sites as $site) {
        foreach (get('writable_dir_names') as $writableDirName) {
            $writableDirs[] = parse(\str_replace('{{site}}', $site, $writableDirName));
        }
    }

    set('writable_dirs', $writableDirs);
});
