<?php
namespace Deployer;

task('cms:drupal:db:backup:download', function () {
  runLocally('mkdir -p {{local_database_backups}}');
  download('{{backups}}/latest/*', '{{local_database_backups}}', ['--copy-links']);
})->desc('Download the latest database backups.')->once();
