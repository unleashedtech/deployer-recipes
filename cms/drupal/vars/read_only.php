<?php

/**
 * Initialize read_only array multi-site variable.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:vars:read_only', static function (): void {
    $readOnly = [];
    $sites    = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        foreach (get('read_only_names') as $readOnlyName) {
            $readOnly[] = parse(\str_replace('{{site}}', $site, $readOnlyName));
        }
    }

    set('read_only', $readOnly);
});
