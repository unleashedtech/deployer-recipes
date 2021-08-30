<?php
namespace Deployer;

task('drupal:db:backup:import', function () {
  $latestBackup = run("find tmp -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -f2- -d\" \"");
  vm("cd {{app_dir_name}} && zcat ../$latestBackup | drush sqlq");
})->desc('Import the latest database backup(s).')
  ->local()
  ->once();
