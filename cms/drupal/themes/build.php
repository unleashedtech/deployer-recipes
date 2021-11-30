<?php

/**
 * Builds Drupal theme(s).
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:themes:build', static function (): void {
    foreach (get('themes') as $theme) {
        within(get('release') . '/' . $theme, static function (): void {
            // @todo Detect theme package manager & task runner. Run commands based on that data.
            run('npm install');
            run('gulp build');
        });
    }
});
