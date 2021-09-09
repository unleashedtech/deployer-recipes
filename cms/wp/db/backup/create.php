<?php
/**
 * Create a Wordpress database backup.
 *
 * @package wordpress
 */

namespace Deployer;

task(
	'wp:db:backup:create',
	function () {
		// Ensure that the backup directory exists.
		run( 'mkdir -p {{backups}}' );

		within(
			get( 'repo' ),
			function () {
                $date = date( 'Y-m-d--H-i-s' );
                $filename = '{{hostname}}--' . $date . '.sql';
				run( "{{wp}} db export {{backups}}/" . $filename . " --add-drop-table", array( 'timeout' => 60 * 20 ) );
			}
		);
	}
)->desc( 'Create a database backup file and gzip it.' )->once();
