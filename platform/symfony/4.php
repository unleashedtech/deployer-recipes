<?php

/**
 * Symfony 4 Deployer recipe.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/../../src/functions.php';

// Conditionally apply Drupal-specific defaults.
set('app_type', 'symfony');
fill('shared_dir_names', []);
fill('shared_file_names', [
    '.env',
]);
fill('skip_db_update', false);
fill('skip_cache_rebuild', false);
fill('writable_dir_names', []);

// Import necessary recipes.
import('vendor/unleashedtech/deployer-recipes/config.php');
config_backup();
import('recipe/symfony.php');
config_backup_merge();
import('vendor/unleashedtech/deployer-recipes/dev/todo.php');
import('vendor/unleashedtech/deployer-recipes/db/backup/cleanup.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/assets/install.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/assets/compile.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/cache/rebuild.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/cache/warmup.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/db/backup/create.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/db/migrate.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/fixtures/load.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/post/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/pre/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/pre/release.yml');
import('vendor/unleashedtech/deployer-recipes/platform/symfony/workers/restart.yml');
import('vendor/unleashedtech/deployer-recipes/pm/yarn/install.yml');
import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

// Create the "deploy" task.
task('deploy', [
    'platform:symfony:pre:release',
    'deploy:prepare',
    'platform:symfony:pre:deploy',
    'deploy:symlink',
    'platform:symfony:post:deploy',
]);
