<?php

declare(strict_types=1);

namespace UnleashedTech\DeployerRecipes\VirtualMachine\Docksal;

use UnleashedTech\DeployerRecipes\VirtualMachine\AbstractClient;

use function Deployer\runLocally;

class Client extends AbstractClient
{
    public function run(string $command): string
    {
        return runLocally(\sprintf('fin exec "%s"', $command), [], $this->getClientTimeout());
    }

    public function import(string $file): string
    {
        $this->drush('sql-drop -y');
        $isCompressed = \str_ends_with($file, '.gz');
        if ($isCompressed) {
            return runLocally(\sprintf('zcat < %s | fin db import', $file), [], $this->getClientTimeout());
        }

        return runLocally(\sprintf('fin db import "%s"', $file), [], $this->getClientTimeout());
    }
}
