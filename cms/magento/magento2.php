<?php

/**
 * Magento 2 Deployer recipe.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

use Deployer\Exception\RunException;

require_once __DIR__ . '/../../src/functions.php';
import('recipe/common.php');

set('app_type', 'magento');
set('mage', 'bin/magento');
fill('shared_dirs', [
    'var/composer_home',
    'var/log',
    'var/export',
    'var/report',
    'var/import',
    'var/import_history',
    'var/session',
    'var/importexport',
    'var/backups',
    'var/tmp',
    'pub/sitemap',
    'pub/media',
]);
fill('shared_files', [
    'app/etc/env.php',
    'var/.maintenance.ip'
]);
fill('writable_dirs', [
    'var',
    'pub/static',
    'pub/media',
    'generated',
    'pub/page-cache'
]);
fill('clear_paths', [
    'generated/*',
    'pub/static/_cache/*',
    'var/generation/*',
    'var/cache/*',
    'var/page_cache/*',
    'var/view_preprocessed/*'
]);
fill('app_directory_name', 'docroot');
set('static_content_locales', 'en_US');
set('http_user', 'www-data');
//set('writable_use_sudo',true);
fill('writable_recursive', 'true');

import('vendor/unleashedtech/deployer-recipes/config.php');

/**
 * Initialize writable_dirs variable.
 *
 * Add the app_directory_name as a prefix to the writable_dirs array.
 *
 * The `writable_dirs` array can be manually overridden in `deploy.yaml`.
 *
 */
task('magento:init', static function (): void {
    $vars = ['shared_dirs', 'shared_files', 'writable_dirs', 'clear_paths'];
    $appDir = get('app_directory_name');

    foreach ($vars as $var) {
        $newVars = [];
        foreach (get($var) as $file_dir) {
            $newVars[] = $appDir . '/' . $file_dir;
        }
        set($var, $newVars);
    }
    invoke("deploy:unlock");
});

desc('Enables maintenance mode');
task('magento:maintenance:enable', function () {
    $exists = test('[ -d {{current_path}} ]');
    if ($exists) {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('{{mage}} maintenance:enable');
            }
        );
    }
});

desc('Disables maintenance mode');
task(
    'magento:maintenance:disable',
    function () {
        $exists = test('[ -d {{current_path}} ]');
        if ($exists) {
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                function () {
                    run('{{mage}} maintenance:disable');
                }
            );
        }
    }
);

task('magento:post:deploy', function () {
    /*
     * Unfortunately IT DevOps team requests we not give the deployer user passwordless sudo access
     * which chown/chgrp requires.
     * Therefore we use a custom created deployment-permisssions.sh script sitting at the user
     * home directory.
     * Otherwise, this is the way we would set the proper permissions.
    $modes = ['chmod', 'chown', 'chgrp'];

    foreach ($modes as $mode) {
        set('writable_mode', $mode);
        invoke('deploy:writable');
    }
     */
    within(
        '{{app_path}}',
        function () {
            run('sudo ~/deployment-permissions.sh');
            invoke('deploy:shared'); // restore env.php to link
        }
    );
});

task(
    'magento:indexer:reindex',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('{{mage}} indexer:reindex');
            }
        );
    }
);

desc('Flushes Magento Cache');
task(
    'magento:cache:flush',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('{{mage}} cache:clean');
                run('{{mage}} cache:flush');
            }
        );
    }
);

desc('Composer install inside docroot (behind auth wall');
task(
    'magento:deploy:vendor',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('composer install');
            }
        );
    }
);

desc('Compile Magento Code');
task(
    'magento:compile',
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
);

desc('Database Configuration Import');
task(
    'cms:magento:config:import',
    function () {
        $configImportNeeded = false;
        // Make sure we have a current_path directory, otherwise pass.
        $exists = test('[ -d {{current_path}} ]');
        if (!$exists) {
            // Pass. Don't need to do backup if it's the first time.
            return;
        }
        try {
            // See if we can check the db status.
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                function () {
                    run('{{mage}} app:config:status');
                }
            );
        } catch (RunException $e) {
            if ($e->getExitCode() == 2) {
                $configImportNeeded = true;
            } else {
                throw $e;
            }
        }

        if ($configImportNeeded) {
            within(
                '{{release_or_current_path}}/{{app_directory_name}}',
                function () {
                    run('{{mage}} app:config:import --no-interaction');
                }
            );
        }
    }
);

desc(' Force Install a new cron.');
task(
    'cms:magento:cron',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('crontab -r'); // This helps when multiple previous cron installations have not cleaned up after themselves.
                run('{{mage}} cron:install -f');
            }
        );
    }
);

desc('Database Backup');
task(
    'magento:db:backup:create',
    function () {
        // Make sure we have a current_path directory, otherwise pass.
        $exists = test('[ -d {{current_path}} ]');
        if (!$exists) {
            // Pass. Don't need to do backup if it's the first time.
            return;
        }
        try {
            within(
                get('app_path'),
                function () {
                    run('{{mage}} setup:db:status');
                }
            );
        } catch (RunException $e) {
            if ($e->getExitCode() == 2) {
                return;
            }
        }

        try {
            within(
                get('app_path'),
                function () {
                    run('{{mage}} config:set system/backup/functionality_enabled 1');
                }
            );
        } catch (RunException $e) {
            return;
        }

        // Create the backup file.
        within(
            get('app_path'),
            function () {
                run('{{mage}} setup:backup --db', ['timeout' => null]);
                run('{{mage}} info:backups:list');
            }
        );
    }
);

task(
    'magento:db:upgrade',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                run('rm app/etc/env.php'); // To get around default website not being set error
                run('cp ../../../shared/docroot/app/etc/env.php app/etc/env.php'); // Temp file placement for static-content command
                run('{{mage}} module:disable Magento_TwoFactorAuth');
                run('{{mage}} setup:upgrade --keep-generated --no-interaction');
            }
        );
    }
);

task('magento:db:pull', function () {
    invoke('magento:db:backup:create');
    invoke('db:backup:download');
    invoke('magento:db:backup:import');
    invoke('db:backup:cleanup');
});

desc('Deploy Assets');
task(
    'cms:magento:deploy:assets',
    function () {
        within(
            '{{release_or_current_path}}/{{app_directory_name}}',
            function () {
                $timestamp = \time();
                run('rm app/etc/env.php'); // To get around default website not being set error
                run('cp ../../../shared/docroot/app/etc/env.php app/etc/env.php'); // Temp file placement for static-content command
                // The static deploy actually REQUIRES that the env.php be writable.
                // Therefore we copy it.
                run('{{mage}} setup:static-content:deploy -f --content-version=' . $timestamp . ' {{static_content_locales}}');
            }
        );
    }
);

import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

desc('Magento2 Deployment Tasks');
task('deploy:magento2', [
    'magento:deploy:vendor',
    'magento:db:backup:create',
    'magento:maintenance:enable',
    'magento:db:upgrade',
    'magento:deploy:assets',
    'magento:compile',
    'magento:config:import',
    'magento:cache:flush',
    'magento:indexer:reindex',
    'magento:cron',
    'magento:maintenance:disable'
]);

task('deploy', [
    'magento:init',
    'deploy:prepare',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:magento2',
    'deploy:publish',
    'releases:cleanup',
    'deploy:unlock',
    'magento:post:deploy'
]);

after('deploy:failed', 'magento:maintenance:disable');
after('deploy:failed', 'deploy:unlock');

