<?php
/**
 * Download the latest database backup file.
 *
 * @package wordpress
 */

namespace Deployer;

task('wp:db:backup:download', function () {
  $latestBackup = run("find {{backups}}/ -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -f2- -d\" \"");
  download($latestBackup, "{{backups}}/$stage.sql.gz" );
})->desc('Download the latest database backup.')->once();
