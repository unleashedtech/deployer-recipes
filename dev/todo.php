<?php

declare(strict_types=1);

namespace Deployer;

use Deployer\Task\Context;

task('dev:todo', static function (): void {
    $context = \debug_backtrace()[2]['args'][0];
    \assert($context instanceof Context);
    $task = null;

    throw new \BadFunctionCallException('Please implement parent task. Please run `dep tree deploy` for a full list of tasks & dependencies.');
});
