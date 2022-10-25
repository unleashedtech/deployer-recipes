<?php

/**
 * File Permission Commands
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:drupal:perms:harden', static function (): void {
    $appPath   = get('app_path');
    $readOnlys = get('read_only');

    foreach ($readOnlys as $fileOrDir) {
        within($appPath, static function (): void {
            run('chmod 444 ' . $fileOrDir);
        });
    }
})->desc('Chmod read_only files to read only.')->once();
