<?php

declare(strict_types=1);

namespace Deployer;

task('dev:config', static function (): void {
    print_r(Deployer::get()->config->ownValues());
})->local();
