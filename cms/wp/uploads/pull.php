<?php

/**
 * Wordpress Uploads Pull (rsync)
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'platform:wp:uploads:pull',
    static function (): void {
        writeln('<comment>> Receive remote uploads ... </comment>');
        // This does assume you have your ssh keys installed on the server.
        runLocally("rsync -avzO --no-o --no-g -e 'ssh' {{user}}@{{hostname}}:{{deploy_path}}/shared/{{upload_dir}}/ {{upload_dir}}");
    }
)->desc('Sync uploads');
