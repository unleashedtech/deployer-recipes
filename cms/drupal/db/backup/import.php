<?php

/**
 * Drupal database import.
 *
 * @files
 */

declare(strict_types=1);

namespace Deployer;

// TODO: remove these two lines once autoloader issue is resolved.
require_once 'vendor/unleashedtech/deployer-recipes/src/VirtualMachine/VirtualMachine.php';

use UnleashedTech\DeployerRecipes\VirtualMachine\VirtualMachine;

task('cms:drupal:db:backup:import', static function (): void {
    $latestBackup = runLocally('ls -tr -1 {{local_database_backups}} | tail -1');
    $vm           = VirtualMachine::load();
    $vm->import('{{local_database_backups}}/' . $latestBackup);
    $vm->drush('cr');
})->desc('Import the latest database backup(s).')
    ->once();
