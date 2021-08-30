<?php
namespace Deployer;

/**
 * Runs a command within the VM.
 * TODO: Define a `localhost` host that tells Deployer how to connect to the VM, so any task can be run within the VM.
 *       This may mean the web container needs to be configured to provide standard-fare SSH connectivity.
 *
 * @param string $command
 *
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 * @deprecated in favor of a `localhost` host that points to the Docksal container
 */
function vm(string $command) {
  if (is_file('.docksal/docksal.yml')) {
    run("fin exec '$command'");
  }
  else {
    throw new \UnexpectedValueException('Unsupported VM.');
  }
}
