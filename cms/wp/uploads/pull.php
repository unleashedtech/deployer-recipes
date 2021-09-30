<?php
/**
 * Wordpress Uploads Pull (rsync)
 *
 * @file
 * @package wp-deployer
 */

namespace Deployer;

task(
	'cms:wp:uploads:pull',
	function() {
		$upload_dir = 'web/app/uploads';
		writeln( '<comment>> Receive remote uploads ... </comment>' );
        // This does assume you have your ssh keys installed on the server.
		runLocally( "rsync -avzO --no-o --no-g -e 'ssh' {{user}}@{{hostname}}:{{deploy_path}}/shared/$upload_dir/ $upload_dir" );

	}
)->desc( 'Sync uploads' );
