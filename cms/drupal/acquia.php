<?php

/**
 * Drupal Deploy on Acquia Servers using BLT and Acli
 *
 * Both BLT and acli are required to be authenticated and setup.
 * https://docs.acquia.com/blt/
 * https://docs.acquia.com/acquia-cli/
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/../../src/functions.php';

// Conditionally apply Drupal-specific defaults.
set('app_type', 'drupal');
fill('drush', '{{bin}}/drush');
fill('sites', ['default']);
fill('shared_dir_names', [
    'drupal/temporary_files',
    'drupal/private_files',
    '{{app_directory_name}}/sites/{{site}}/files',
]);
fill('shared_file_names', [
    '.env',
    '{{app_directory_name}}/sites/{{site}}/config.local.php',
    '{{app_directory_name}}/sites/{{site}}/databases.local.php',
    '{{app_directory_name}}/sites/{{site}}/settings.local.php',
]);
fill('skip_db_update', false);
fill('skip_cache_rebuild', false);
fill('skip_config_import', false);
fill('themes', ['{{app_directory_name}}/themes/custom/{{namespace}}_theme']);
fill('writable_dir_names', []);

// Import necessary recipes.
import('vendor/unleashedtech/deployer-recipes/config.php');
config_backup();
import('recipe/drupal8.php');
config_backup_merge();
import('vendor/unleashedtech/deployer-recipes/db/backup/download.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/create.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/import.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/pull.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/vars/vars.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/post/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/pre/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/tools/login.yml');
import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

/**
  rm -rf deploy/*
  rm -rf docroot/sites/default/files/*
  vendor/bin/blt artifact:deploy --tag "${releaseVersion}-artifact-deploy" --commit-msg "$blt_version deployed artifact $releaseVersion Contains $tk"
  git tag -a ${releaseVersion}-source -m "$description"
  git push acquia ${releaseVersion}-source
  git push
  acli api:environments:database-backup-create $destEnvAlias $databaseName
  acli api:environments:code-switch $destEnvAlias tags/${releaseVersion}-artifact-deploy
*/

// Create the "deploy" task.
task('deploy', [
    'artifact:prep',
    'artifact:deploy',
    'artifact:tag',
    'artifact:push',
    'acli:backup',
    'acli:code-switch',
]);
