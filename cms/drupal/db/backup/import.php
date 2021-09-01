<?php

namespace Deployer;

// TODO: remove these two lines once autoloader issue is resolved.
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine.php';

use UnleashedTech\DeployerRecipes\VirtualMachine;

task('cms:drupal:db:backup:import', function () {
    $latestBackup = run("find tmp -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -f2- -d\" \"");
    VirtualMachine::run("cd {{app_directory_name}} && gunzip -c ../$latestBackup | drush sql:cli");
})->desc('Import the latest database backup(s).')
    ->local()
    ->once();
