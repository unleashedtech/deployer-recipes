<?php

/**
 * Post Deploy - To chown to web server user
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:magento:post:deploy', static function (): void {
    /*
    $modes = ['chmod', 'chown', 'chgrp'];

    foreach ($modes as $mode) {
        set('writable_mode', $mode);
        invoke('deploy:writable');
    }
     */
    within('{{app_path}}',
        function () {
            run('sudo ~/deployment-permissions.sh');
            // We need to turn off TwoFactorAuth for logging in
            // but in doing so removes the generated files.
            //run('{{mage}} module:disable Magento_TwoFactorAuth');
        });
});
