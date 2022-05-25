<?php

/**
 * Defines config, if not already defined.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/src/functions.php';

import('vendor/unleashedtech/deployer-recipes/dev/sites.php');

// Conditionally apply global defaults.
fill('app_path', '{{release}}/{{app_directory_name}}');
fill('app_directory_name', 'web');
fill('allow_anonymous_stats', false);
fill('backups', '{{deploy_path}}/shared/backups');
fill('backups_limit', 21);
fill('bin', '{{release}}/vendor/bin');
fill('composer_install_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --no-scripts --optimize-autoloader');
fill('deploy_root', '/srv/www');
fill('default_stage', 'staging');
fill('environments', ['dev', 'staging', 'production']);
fill('environments_protected', ['production']);
fill('local_backups', 'backups');
fill('local_database_backups', '{{local_backups}}/databases');
fill('local_file_backups', '{{local_backups}}/files');
fill('project', '{{app_type}}');
fill('repository', '{{repository_user}}@{{repository_domain}}:{{repository_namespace}}/{{repository_project}}.git');
fill('repository_domain', 'repository.example');
fill('repository_namespace', '{{namespace}}');
fill('repository_project', '{{project}}');
fill('repository_user', 'git');
fill('skip_db_backup', false);
fill('skip_db_ops', false);
fill('ssh_multiplexing', true);

// Automatically unlock after a deployment failure.
// TODO: something like the following needs to occur _after_ the deploy:failed task is defined
// TODO: after('deploy:failed', 'deploy:unlock');

// Set release name.
$branch = get('branch');
$format = 'Y-m-d-H-i-s';
if ($branch === null || $branch === 'HEAD') {
    set('release_name', \date($format));
} else {
    set('release_name', \date($format) . '-' . \preg_replace('/[^a-zA-Z0-9\']/', '-', $branch));
}

// Define local host(s).
localhost('localhost', '{{namespace}}-{{project}}-vm-web');

// Fill environment-related variables & define remote host(s).
$environments = get('environments');
if (! \is_array($environments)) {
    $environments = \explode(',', $environments);
}

foreach ($environments as $env) {
    // Fill environment-related variables.
    fill($env . '_deploy_path', '{{deploy_root}}/{{' . $env . '_host}}');
    fill($env . '_name', '{{namespace}}-{{project}}-' . $env . '-web');
    fill($env . '_domain', $env . '.example');
    if ($env === 'production') {
        fill($env . '_host', '{{' . $env . '_domain}}');
    } else {
        fill($env . '_host', '{{namespace}}.{{' . $env . '_domain}}');
    }

    // Do not define a host if an example TLD is set.
    if (get($env . '_domain') === $env . '.example') {
        continue;
    }

    // Create the hostnames array.
    $hostnames      = [];
    $webserverCount = get($env . '_webservers', $env === 'production' ? 2 : 1);
    for ($i = 0; $i < $webserverCount; $i++) {
        $suffix = '';
        if ($webserverCount > 1) {
            $suffix = $i;
        }

        $hostnames[] = get($env . '_name') . $suffix;
    }

    // Define the host(s) & associate them with the given environment as a "stage".
    host(...$hostnames)
        ->setLabels(['stage' => $env])
        ->set('deploy_path', get($env . '_deploy_path'))
        ->set('release', '{{deploy_path}}/current')
        ->setSshMultiplexing((bool) get('ssh_multiplexing'));
}
