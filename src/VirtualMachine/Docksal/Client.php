<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Docksal;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function run(string $command): void
    {
        runLocally(\sprintf('fin exec "%s"', $command));
    }

    public function import(string $file): void
    {
        $this->drush('sql-drop -y');
        $isCompressed = str_ends_with($file, '.gz');
        if ($isCompressed) {
            runLocally(\sprintf('zcat < %s | fin db import', $file));
        } else {
            runLocally(\sprintf('fin db import "%s"', $file));
        }
    }
}
