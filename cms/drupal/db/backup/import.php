<?php

namespace Deployer;

// TODO: remove these two lines once autoloader issue is resolved.
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine.php';

use UnleashedTech\DeployerRecipes\VirtualMachine;

task('cms:drupal:db:backup:import', function () {
    $latestBackup = runLocally("find {{local_database_backups}} -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -f2- -d\" \"");
    VirtualMachine::run("drush -r {{app_directory_name}} rq && drush sql-drop || echo 'Database not available.'");
    VirtualMachine::run("gunzip -c $latestBackup | drush -r {{app_directory_name}} sql:cli");
})->desc('Import the latest database backup(s).')
    ->local()
    ->once();
