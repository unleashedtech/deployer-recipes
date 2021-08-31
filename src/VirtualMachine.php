<?php

namespace UnleashedTech\DeployerRecipes;

/**
 * Class VirtualMachine.
 * @internal
 *
 * TODO: Define a `localhost` host that tells Deployer how to connect to the VM, so any task can be run within the VM.
 *       This may mean the web container needs to be configured to provide standard-fare SSH connectivity.
 */
class VirtualMachine {
    public static function run(string $command) {
        if (is_file('.docksal/docksal.yml')) {
            run("fin exec '$command'");
        }
        elseif (is_file('.ddev/config.yaml')) {
            run("ddev exec '$command'");
        }
        else {
            throw new \UnexpectedValueException('Unsupported VM.');
        }
    }
}
