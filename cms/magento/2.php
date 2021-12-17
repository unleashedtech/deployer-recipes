<?php

/**
 * Magento 2 Deployer recipe.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/../../src/functions.php';

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
fill('static_content_locales', 'en_US');
fill('http_user', 'www-data');
fill('writable_recursive','true');

import('vendor/unleashedtech/deployer-recipes/config.php');
import('vendor/unleashedtech/deployer-recipes/cms/magento/init/app_dir_prefix.php');
import('vendor/unleashedtech/deployer-recipes/cms/magento/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/magento/post/deploy.php');
import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

task('deploy', [
    'cms:magento:init',
    'deploy:prepare',
    'deploy:vendors',
    'deploy:clear_paths',
    'cms:magento:deploy',
    'deploy:publish',
    'releases:cleanup',
    'deploy:unlock',
    'cms:magento:post:deploy'
]);
