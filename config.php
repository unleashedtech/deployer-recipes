<?php

/**
 * Defines config, if not already defined.
 *
 * @file
 */

declare(strict_types=1);

namespace Deployer;

/**
 * Sets a config parameter to the given value if it is not already set.
 *
 * @param string $var
 *   The config parameter to conditionally set.
 * @param mixed  $defaultValue
 *   The config parameter value to conditionally set.
 */
function fill(string $var, $defaultValue): void
{
    if (! has($var) || \trim(get($var)) === '') {
        set($var, $defaultValue);
    }
}

fill('app_path', '{{release}}/{{app_directory_name}}');
fill('app_directory_name', 'web');
fill('allow_anonymous_stats', false);
fill('backups', '{{deploy_path}}/shared/backups');
fill('backups_limit', 21);
fill('bin', '{{release}}/vendor/bin');
fill('composer_install_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --no-scripts --optimize-autoloader');
fill('deploy_root', '/srv/www');
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

//# Dev "stage" global variables.
fill('dev_deploy_path', '{{deploy_root}}/{{dev_host}}');
fill('dev_host', '{{namespace}}.{{dev_domain}}');
fill('dev_name', '{{namespace}}-dev');
fill('dev_domain', 'dev.example');

//# Staging "stage" global variables.
fill('staging_deploy_path', '{{deploy_root}}/{{staging_host}}');
fill('staging_host', '{{namespace}}.{{staging_domain}}');
fill('staging_name', '{{namespace}}-staging');
fill('staging_domain', 'staging.example');

//# Production "stage" global variables.
fill('production_deploy_path', '{{deploy_root}}/{{production_host}}');
fill('production_host', '{{production_domain}}');
fill('production_name', '{{namespace}}-production');
fill('production_domain', 'production.example');

// Define dev host.
if (get('dev_domain') !== 'dev.example') {
    host('dev')
        ->set('labels', ['stage' => 'dev'])
        ->set('deploy_path', '{{dev_deploy_path}}')
        ->set('hostname', '{{dev_name}}')
        ->set('release', '{{deploy_path}}/current');
}

// Define staging host.
if (get('staging_domain') !== 'staging.example') {
    host('staging')
        ->set('labels', ['stage' => 'staging'])
        ->set('deploy_path', '{{staging_deploy_path}}')
        ->set('hostname', '{{staging_name}}')
        ->set('release', '{{deploy_path}}/current');
}

// Define production host(s).
if (get('production_domain') !== 'production.example') {
    $prodHosts      = 'production';
    $webserverCount = get('production_webservers', 2);
    if ($webserverCount > 1) {
        $prodHosts .= '[0:' . ($webserverCount - 1) . ']';
    }

    host($prodHosts)
        ->set('labels', ['stage' => 'production'])
        ->set('deploy_path', '{{production_deploy_path}}')
        ->set('hostname', '{{production_name}}')
        ->set('release', '{{deploy_path}}/current');
}
