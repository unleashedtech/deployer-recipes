<?php

/**
 * Copy the latest database backup file.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Host\Host;

task('cms:drupal:db:backup:copy', static function (): void {
    // Get the environments the file(s) should be copied to.
    $environments = get('environments_copy_db_files');
    if (! \count($environments)) {
        error('Destination environments required.');
    }

    // Get the list of files to copy.
    $files = [];
    $sites = get('sites');
    if (! \is_array($sites)) {
        $sites = \explode(',', $sites);
    }

    foreach ($sites as $site) {
        $files[] = run('\ls -rt -1 {{backups}} | grep "' . $site . '" | tail -1');
    }

    // Copy the files to the destination environment(s).
    foreach ($environments as $environment) {
        if ($environment === 'local') {
            // TODO: transfer directly into the VM via scp instead of using runLocally
            runLocally('mkdir -p {{local_database_backups}}');
            foreach ($files as $file) {
                download('{{backups}}/' . $file, '{{local_database_backups}}/');
            }
        } else {
            $currentHost = currentHost();
            foreach (Deployer::get()->hosts as $destHost) {
                \assert($destHost instanceof Host);
                if ($environment !== $destHost->getLabels()['stage']) {
                    continue;
                }

                foreach ($files as $file) {
                    $sourceFilename = '{{backups}}/' . $file;
                    $destFilename   = '{{backups}}/' . $file;
                    // Only copy the file if it does not already exist at the destination.
                    $exists = (bool) runLocally(\vsprintf('ssh %s [ -f %s ] && echo 1 || echo 0', [
                        $destHost->getHostname(),
                        $destFilename,
                    ]));
                    if ($exists) {
                        continue;
                    }

                    info(\vsprintf('Copying "%s" to "%s".', [
                        $file,
                        $destHost->getHostname(),
                    ]));
                    runLocally(\vsprintf('scp -3 %s %s', [
                        $currentHost->getHostname() . ':' . $sourceFilename,
                        $destHost->getHostname() . ':' . $destFilename,
                    ]));
                }
            }
        }
    }
})->desc('Copy the latest database backup(s).')->once();
