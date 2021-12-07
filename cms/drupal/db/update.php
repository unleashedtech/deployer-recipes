<?php

task('cms:drupal:db:update', static function (): void {
    if (get('skip_db_ops') || get('skip_db_update')) {
        return;
    }

    run('{{drush}} updb -y');
})->desc('Updates the Drupal DB based on Drupal install files.');
