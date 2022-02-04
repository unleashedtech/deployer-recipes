<?php

/**
 * Wordpress Uploads Push (rsync)
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'platform:wp:uploads:push',
    static function (): void {
        writeln('<comment>> Remote Copy uploads ... </comment>');
        // This does assume you have your ssh keys installed on the server.
        runLocally("rsync -avzO --no-o --no-g -e 'ssh' {{upload_dir}}/ {{hostname}}:{{deploy_path}}/shared/{{upload_dir}}/");
    }
)->desc('Push uploads');
