<?php

/**
 * Wordpress Database Backup Import.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:wp:db:backup:import',
    static function (): void {
        $latestBackup = runLocally('\ls -rt -1 {{local_database_backups}} | tail -1');
        // The issue with trying to re-use {{wp}} is that it is that the  machine environment is a remote server and so {{wp}} exists in a different
        // directory.  The same justification necessitates {{local_backups}} definition
        runLocally('cd web && {{local_wp}} db import ../{{local_database_backups}}/' . $latestBackup);
        writeln('<comment>> Database file > <info>' . $latestBackup . '</info> has been imported locally! </comment>');
    }
)->desc('Import the latest database backup.')
  ->local()
  ->once();
