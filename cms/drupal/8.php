<?php

/**
 * Drupal 8 Deployer recipe.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/../../src/functions.php';

set('app_type', 'drupal');
fill('drush', '{{bin}}/drush');
fill('sites', ['default']);
fill('shared_dir_names', ['{{app_directory_name}}/sites/{{site}}/files']);
fill('shared_file_names', ['.env']);
fill('skip_db_update', false);
fill('skip_cache_rebuild', false);
fill('skip_config_import', false);
fill('themes', ['{{app_directory_name}}/themes/custom/{{namespace}}_theme']);
fill('writable_dir_names', ['{{app_directory_name}}/sites/{{site}}/files']);

import('recipe/drupal8.php');
import('vendor/unleashedtech/deployer-recipes/config.php');
import('vendor/unleashedtech/deployer-recipes/db/backup/download.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/create.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/backup/import.php');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/db/pull.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/vars/vars.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/post/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/pre/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/drupal/tools/login.yml');
import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

task('deploy', [
    'cms:drupal:db:backup:create',
    'cms:drupal:vars',
    'deploy:prepare',
    'cms:drupal:pre:deploy',
    'deploy:symlink',
    'cms:drupal:post:deploy',
]);
