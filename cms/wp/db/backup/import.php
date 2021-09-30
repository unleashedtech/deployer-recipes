<?php
/**
 * Wordpress Database Backup Import.
 *
 * @file
 * @package wp-deployer
 */

namespace Deployer;

task(
	'cms:wp:db:backup:import',
	function () {
		$latestBackup = run( "\ls -rt -1 {{local_backups}} | tail -1" );
        // The issue with trying to re-use {{wp}} is that it is that the  machine environment is a remote server and so {{wp}} exists in a different
        // directory.  The same justification necessitates {{local_backups}} definition
		run( "cd web && {{local_wp}} db import ../{{local_backups}}/$latestBackup" );
		writeln( '<comment>> Database file > <info>' . $latestBackup . '</info> has been imported locally! </comment>' );
	}
)->desc( 'Import the latest database backup.' )
  ->local()
  ->once();
