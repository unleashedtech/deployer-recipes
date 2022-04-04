# Magento Deployer 7 Config

```yaml
config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example'
    dev_domain: 'dev1.example'
    staging_domain: 'staging1.example'
    production_domain: 'production1.example'
    upload_dir: 'docroot/app/uploads'
import:
    - 'vendor/unleashedtech/deployer-recipes/cms/magento/magento2.php'
```

Many defaults are provided. You will need to override a few of them. Your configuration
may be as simple as:

```yaml
config:
    namespace: foo
    repository_domain: 'repository1.example'
    staging_domain: 'staging1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/cms/magento/magento2.php'
```

[Magento2 Deployment Strategies and Discussions](https://magento.stackexchange.com/questions/315786/magento-2-configuration-settings-clarify-appconfigdump-vs-appconfigimport)


## NOTES on Linux File Permissions

In order for the linux deployer user (whom is probably a different user than the www-data nginx user) you will need to have the following ownership
and setguid bits set on the destination servers.

##### This is a one time setup so that all shared files are owned by Nginx and all future created subdirs

    ```bash
    sudo chown -R www-data:www-data /srv/www/{{your deploy project name}}/shared/docroot
    chmod g+s /srv/www/{{your deploy project name}}/shared/docroot
    chmod g+s /srv/www/{{your deploy project name}}/shared/docroot/*
    ```
##### One time Setup so all releases are owned by Nginx and all future created subdirs

    ```bash
    sudo chown www-data:www-data /srv/www/{{your deploy project name}}/releases
    chmod g+s /srv/www/{{your deploy project name}}/releases
    ```

##### These files are owned by www-data from above command
##### this needs to be writable by deployer who is a part of the www-data group.

    ```bash
    chmod 664 /srv/www/{{your deploy project name}}/shared/docroot/app/etc/env.php
    chmod 664 /srv/www/{{your deploy project name}}/shared/docroot/app/etc/config.php
    ```


