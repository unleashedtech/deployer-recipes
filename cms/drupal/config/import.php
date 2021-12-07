<?php

task('cms:drupal:db:update', static function (): void {
    if (get('skip_db_ops') || get('skip_config_import')) {
        return;
    }

    run('{{drush}} config:import -y');
})->desc('Imports config into Drupal from code in the repo.');
