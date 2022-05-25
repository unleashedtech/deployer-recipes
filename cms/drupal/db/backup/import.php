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
    $vm    = VirtualMachine::load('drupal');
    $sites = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        // TODO: update this to run on {{backup_destination_host}}
        $file = runLocally('ls -tr -1 {{local_database_backups}} | grep "' . $site . '" | tail -1');
        $vm->import('{{local_database_backups}}/' . $file, $site);
        $vm->drush('cr', $site);
    }
})->desc('Import the latest database backup(s).')
    ->once();
