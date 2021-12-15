<?php

/**
 * WordPress 5 Deployer recipe.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/../../src/functions.php';

set('app_type', 'wordpress');
fill('upload_dir', 'web/app/uploads');
fill('shared_files', ['.env']);
fill('shared_dirs', ['{{upload_dir}}']);
fill('writable_dirs', ['{{upload_dir}}']);
fill('wp', '{{bin}}/wp');

import('recipe/common.php');
import('recipe/wordpress.php');
import('vendor/unleashedtech/deployer-recipes/config.php');
import('vendor/unleashedtech/deployer-recipes/cms/wp/cache/flush.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/rewrite/flush.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/db/backup/create.php');
import('vendor/unleashedtech/deployer-recipes/db/backup/cleanup.yml');
import('vendor/unleashedtech/deployer-recipes/db/backup/download.php');
import('vendor/unleashedtech/deployer-recipes/cms/wp/db/backup/import.php');
import('vendor/unleashedtech/deployer-recipes/cms/wp/db/pull.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/pre/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/post/deploy.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/pre/release.yml');
import('vendor/unleashedtech/deployer-recipes/cms/wp/uploads/pull.php');
import('vendor/unleashedtech/deployer-recipes/cms/wp/uploads/push.php');
import('vendor/unleashedtech/deployer-recipes/releases/cleanup.php');

task('deploy', [
    'deploy:prepare',
    'cms:wp:pre:deploy',
    'cms:wp:pre:release',
    'deploy:symlink',
    'cms:wp:post:deploy',
]);
