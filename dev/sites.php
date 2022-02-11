<?php

declare(strict_types=1);

namespace Deployer;

task('dev:sites', static function (): void {
    $sites = get('sites');
    if (is_array($sites)) {
        $sites = implode(',', $sites);
    }
    print $sites . PHP_EOL;
});
