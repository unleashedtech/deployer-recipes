<?php

/**
 * @see https://github.com/deployphp/deployer/blob/master/recipe/deploy/vendors.php
 *
 * @file
 * This recipe is based on deploy:vendors, which does not allow variable overrides.
 */

declare(strict_types=1);

namespace Deployer;

require_once 'vars.php';

desc('Installing Composer dependencies.');
task('composer:install', static function (): void {
    if (! commandExist('unzip')) {
        warning('To speed up composer installation setup "unzip" command with PHP zip extension.');
    }

    run('cd {{release_or_current_path}} && {{composer}} install {{composer_install_options}} 2>&1');
});
