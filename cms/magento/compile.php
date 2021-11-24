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
    static function (): void {
        // This might be possible to run before your first actual deploy
        // Thus we do not need the current_path but do need the source
        // code and the database to be installed.  Those are the current assumptions
        $ready = within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            static function (): bool {
                $db_status = run('{{mage}} setup:db:status');
                $app_status = run('{{mage}} app:config:status');
                return $db_status && $app_status;
            }
        );

        if ($ready) {
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                static function (): void {
                    run('composer dump-autoload -o');
                    run('{{mage}} setup:di:compile', ['timeout' => null]);
                    run('composer dump-autoload -o');
                }
            );
        };
    }
)->desc('Create a database backup files.')->once();
