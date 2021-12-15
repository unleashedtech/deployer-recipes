<?php

/**
 * Post Deploy - To chown to web server user
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('cms:magento:post:deploy', static function (): void {
    $modes = ['chmod', 'chown', 'chgrp'];
    foreach ($modes as $mode) {
        set('writable_mode', $mode);
        invoke('deploy:writable');
    }
});
