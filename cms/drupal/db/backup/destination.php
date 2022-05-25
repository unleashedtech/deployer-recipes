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
    // Build the list of host choices.
    $choices   = [
        VirtualMachine::load('drupal')->getName(),
    ];
    $protected = get('environments_protected');
    if (! \is_array($protected)) {
        $protected = \explode(',', $protected);
    }

    foreach (Deployer::get()->hosts as $host) {
        /** @var Host $host */
        $stage = $host->getLabels()['stage'];
        if (! \in_array($stage, $protected, true)) {
            $choices[] = $host->getHostname();
        }
    }

    // Prompt which host the db backup should be imported on.
    set('backup_destination_host', askChoice('Which host should the exported database(s) be imported on?', $choices, 0));
})->desc('Prompt for the database backup destination host.')->once();
