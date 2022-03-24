<?php

/**
 * Initialize shared_dirs variable.
 *
 * Some Drupal applications support multiple sites. To help streamline Deployer
 * configuration, the main Deployer Drupal config defines the `sites` variable
 * which is merely an array of machine names for the set of Drupal sites. The
 * default value for the `sites` variable is an array with one value: `default`.
 * This recipe loops through the `sites` variable & configures shared
 * directories for each site based on the value of the `shared_dir_names`
 * variable.
 *
 * The `shared_dirs` array can be manually overridden in `deploy.yaml`.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:vars:shared:dirs', static function (): void {
    $sharedDirs = [];
    $sites      = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        foreach (get('shared_dir_names') as $sharedDirName) {
            $sharedDirs[] = parse(\str_replace('{{site}}', $site, $sharedDirName));
        }
    }

    set('shared_dirs', $sharedDirs);
});
