<?php

task('cms:drupal:cache:rebuild', static function (): void {
    if (get('skip_db_ops') || get('skip_cache_rebuild')) {
        return;
    }

    run('{{drush}} cr');
})->desc('Rebuilds Drupal caches.');
