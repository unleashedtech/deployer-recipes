<?php

/**
 * Copy the latest database backup file.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use UnleashedTech\DeployerRecipes\VirtualMachine\VirtualMachine;

task('cms:drupal:db:backup:copy', static function (): void {
    // Get the destination host.
    $host = get('backup_destination_host');
    if (! $host) {
        throw new \UnexpectedValueException('Backup destination host required.');
    }

    // Copy it to the destination host.
    if (! \in_array($host, VirtualMachine::getNames(), true)) {
        // TODO: transfer it to the destination host
        throw new \UnexpectedValueException('Host to host file transfer is not supported yet.');
    }

    // TODO: transfer directly into the VM via scp instead of using runLocally
    runLocally('mkdir -p {{local_database_backups}}');
    $sites = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        $file = run('\ls -rt -1 {{backups}} | grep "' . $site . '" | tail -1');
        download('{{backups}}/' . $file, '{{local_database_backups}}/');
    }
})->desc('Download the latest database backup.')->once();
