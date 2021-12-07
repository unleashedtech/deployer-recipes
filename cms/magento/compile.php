<?php

/**
 * Compile the "generated" directory.
 * Reference: https://devdocs.magento.com/guides/v2.3/config-guide/cli/config-cli-subcommands-compiler.html
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

task(
    'cms:magento:compile',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('{{mage}} module:enable --all -c');
                run('composer dump-autoload -o');
                run('{{mage}} setup:di:compile', ['timeout' => null]);
                run('composer dump-autoload -o');
            }
        );
    }
)->desc('Compile Code.')->once();
