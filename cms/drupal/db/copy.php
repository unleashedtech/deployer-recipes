<?php

/**
 * Prompts for the database backup destination host.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Host\Host;

task('cms:drupal:db:copy', static function (): void {
    import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/create.php');
    import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/copy.php');
    import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/import.php');

    // Prompt which environment(s) the db backup(s) should be copied to.
    $destEnvironmentsOptions = [];
    foreach (Deployer::get()->hosts as $host) {
        \assert($host instanceof Host);
        if (! $host->has('labels')) {
            continue;
        }

        $environment = $host->getLabels()['stage'];
        if ($environment !== currentHost()->getLabels()['stage']) {
            $destEnvironmentsOptions[] = $environment;
        }
    }

    $destEnvironments = askChoice('Which environment(s) should the exported database(s) be copied to? (comma separated)', \array_unique($destEnvironmentsOptions), 0, true);
    set('environments_copy_db_files', $destEnvironments);

    // Prompt whether the db backup(s) should be imported.
    $protectedEnvironments = get('environments_protected');
    if (! \is_array($protectedEnvironments)) {
        $protectedEnvironments = \explode(',', $protectedEnvironments ?? '');
    }

    $environmentsToImportDbFiles = [];
    foreach ($destEnvironments as $destEnvironment) {
        if (\in_array($destEnvironment, $protectedEnvironments, true)) {
            info(\vsprintf('Since the "%s" environment is protected, I won\'t ask about importing the DB there...', [
                $destEnvironment,
            ]));
        } else {
            $response = askChoice(\vsprintf('Would you like to import the database file(s) once copied to the "%s" environment?', [
                $destEnvironment,
            ]), ['No', 'Yes'], 0);
            if ($response === 'Yes') {
                $environmentsToImportDbFiles[] = $destEnvironment;
            }
        }
    }

    set('environments_import_db_files', $environmentsToImportDbFiles);

    // Run the related tasks.
    invoke('cms:drupal:db:backup:create');
    invoke('cms:drupal:db:backup:copy');
})->desc('Prompt for the database backup destination host.')->once();
