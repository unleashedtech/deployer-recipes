<?php

/**
 * Drupal databse import.
 *
 * @files
 */

declare(strict_types=1);

namespace Deployer;

// TODO: remove these two lines once autoloader issue is resolved.
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine.php';

use UnleashedTech\DeployerRecipes\VirtualMachine;

task('cms:drupal:db:backup:import', static function (): void {
    $latestBackup = runLocally('ls -tr -1 {{local_database_backups}} | tail -1');
    VirtualMachine::run('drush sql-drop -y');
    VirtualMachine::run('gzip -dfq {{local_database_backups}}/' . $latestBackup );
    $unzipped = runLocally('ls -tr -1 {{local_database_backups}} | tail -1');
    /** SET commands that are exported (mysqldump) from some mysql environments
        (often those coming from master slave environments ) do not import
        on single mysql containers and throw this error:
     *
     *  > ERROR 1227 (42000) at line 18: Access denied; you need (at least one
     *  of) the SUPER, SYSTEM_VARIABLES_ADMIN or SESSION_VARIABLES_ADMIN
     *  privilege(s) for this operation
     *
     *  It is harmless to strip these out for development purposes only.
     */

    VirtualMachine::run("perl -pi -e 's/SET @@.*//gd' " . $unzipped);
    VirtualMachine::run("drush -v sql:cli < " .$unzipped);
    VirtualMachine::run('drush cr');
})->desc('Import the latest database backup(s).')
    ->once();
