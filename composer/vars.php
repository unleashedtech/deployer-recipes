<?php

declare(strict_types=1);

namespace Deployer;

// Returns Composer binary path in found. Otherwise try to install latest
// composer version to `.dep/composer.phar`. To use specific composer version
// download desired phar and place it at `.dep/composer.phar`.
set('composer', static function () {
    if (test('[ -f {{deploy_path}}/.dep/composer.phar ]')) {
        return '{{bin/php}} {{deploy_path}}/.dep/composer.phar';
    }

    if (commandExist('composer')) {
        return '{{bin/php}} ' . which('composer');
    }

    warning("Composer binary wasn't found. Installing latest composer to \"{{deploy_path}}/.dep/composer.phar\".");
    run('cd {{deploy_path}} && curl -sS https://getcomposer.org/installer | {{bin/php}}');
    run('mv {{deploy_path}}/composer.phar {{deploy_path}}/.dep/composer.phar');

    return '{{bin/php}} {{deploy_path}}/.dep/composer.phar';
});
