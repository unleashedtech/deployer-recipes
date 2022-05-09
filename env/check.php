<?php

declare(strict_types=1);

namespace Deployer;

task('env:check', static function (): void {
    // @todo confirm target environment complies with composer-defined requirements
    // (not only check for correct PHP version via CLI, but also via wget?)
});
