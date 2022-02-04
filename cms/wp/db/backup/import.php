<?php

/**
 * Wordpress Database Backup Import.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'platform:wp:db:backup:import',
    static function (): void {
        $latestBackup = runLocally('\ls -rt -1 {{local_database_backups}} | tail -1');
        // The issue with trying to re-use {{wp}} is that it is that the  machine environment is a remote server and so {{wp}} exists in a different
        // directory.  The same justification necessitates {{local_backups}} definition
        runLocally('cd {{app_directory_name}} && wp db import ../{{local_database_backups}}/' . $latestBackup);
        runLocally('cd {{app_directory_name}} && wp cache flush');  // Have to do this locally
        runLocally('cd {{app_directory_name}} && wp rewrite flush');
        writeln('<comment>> Database file > <info>' . $latestBackup . '</info> has been imported locally! </comment>');
    }
)->desc('Import the latest database backup.')
  ->once();
