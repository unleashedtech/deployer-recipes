<?php

/**
 * Copy database(s) to various environments.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task('db:copy', static function (): void {
    $app_type = get('app_type');
    switch($app_type) {
        case 'drupal':
            invoke(\sprintf('cms:%s:db:copy', $app_type));
            break;

        default:
            throw new \DomainException(\sprintf('Unsupported app type: %s', $app_type));
    }
})->desc('Copy database(s) to various environments.')->once();
