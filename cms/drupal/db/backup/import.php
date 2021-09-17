<?php

namespace Deployer;

// TODO: remove these two lines once autoloader issue is resolved.
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine.php';

use UnleashedTech\DeployerRecipes\VirtualMachine;

task('cms:drupal:db:backup:import', function () {
    $latestBackup = runLocally("ls -tr -1 {{local_database_backups}} | tail -1");
    VirtualMachine::run("drush -r {{app_directory_name}} rq && drush sql-drop || echo 'Database not available.'");
    VirtualMachine::run("gunzip -c {{local_database_backups}}/$latestBackup | drush -r {{app_directory_name}} sql:cli");
    VirtualMachine::run("drush -r {{app_directory_name}} cr");
})->desc('Import the latest database backup(s).')
    ->local()
    ->once();
