<?php

/**
 * Prompts for the database backup destination host.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Host\Host;
use UnleashedTech\DeployerRecipes\VirtualMachine\VirtualMachine;

task('cms:drupal:db:backup:destination', static function (): void {
    $backupDestinationHostOptions = [
        VirtualMachine::load('drupal')->getName(),
    ];
    foreach (Deployer::get()->hosts as $host) {
        /** @var Host $host */
        $backupDestinationHostOptions[] = $host->getHostname();
    }

    // Prompt which host the db backup should be imported on.
    set('backup_destination_host', askChoice('Which host should the exported database(s) be copied to?', $backupDestinationHostOptions, 0));
})->desc('Prompt for the database backup destination host.')->once();
