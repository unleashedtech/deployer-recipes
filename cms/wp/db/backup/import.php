<?php
/**
 * Wordpress Database Backup Import.
 *
 * @file
 * @package wp-deployer
 */

namespace Deployer;

task(
	'wp:db:backup:import',
	function () {
		$latestBackup = within( '{{backups}}', "find tmp -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -f2- -d\" \"" );
		run( "cd {{app}} && zcat ../$latestBackup | {{wp}} db import " );
		writeln( '<comment>> Imports db :<info>' . $latestBackup . '</info> </comment>' );
	}
)->desc( 'Import the latest database backup.' )
  ->local()
  ->once();
