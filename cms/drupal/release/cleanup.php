<?php

/**
 * Cleans up old releases. Based on contrib deploy:cleanup task.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

// Use sudo in deploy:cleanup task for rm command.
set('cleanup_use_sudo', false);

desc('Clean up old releases');
task('cms:drupal:release:cleanup', static function (): void {
    $releases = get('releases_list');
    $keep = get('keep_releases');
    $sudo = get('cleanup_use_sudo') ? 'sudo' : '';
    $runOpts = [];

    if ($keep === -1) {
        // Keep unlimited releases.
        return;
    }

    while ($keep > 0) {
        array_shift($releases);
        --$keep;
    }

    foreach ($releases as $release) {
        run("chmod -R +w {{deploy_path}}/releases/$release");
        run("$sudo rm -rf {{deploy_path}}/releases/$release", $runOpts);
    }

    run("cd {{deploy_path}} && if [ -e release ]; then rm release; fi", $runOpts);
});
