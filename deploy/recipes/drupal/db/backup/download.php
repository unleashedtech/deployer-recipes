<?php
namespace Deployer;

task('drupal:db:backup:download', function () {
  download('{{backups}}/latest/*', 'tmp', ['--copy-links']);
})->desc('Download the latest database backups.')->once();
