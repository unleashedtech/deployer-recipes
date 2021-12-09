# UT Deployer Recipes

[![Latest Version](https://img.shields.io/packagist/v/unleashedtech/deployer-recipes.svg?style=flat-square)](https://packagist.org/packages/unleashedtech/deployer-recipes)
[![Software License](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/unleashedtech/deployer-recipes/test/main.svg?style=flat-square)](https://github.com/unleashedtech/deployer-recipes/actions?query=workflow%3Atest+branch%3Amain)

This package uses Deployer 7, which supports recipes defined by YAML or PHP.

Deployer will import the recipes in a linear fashion. Placeholders will be replaced
with actual values as late as possible. Deployer looks for `deploy.php` or
`deploy.yaml` when run.

## Installation

All recipe paths have been adjusted to use the files in the vendor directory
and thus should be installed with composer:

```bash
composer require unleashedtech/deployer-recipes
```

## Usage
Recipes have been organized to easily support any version of any software.
They make several assumptions about git repository settings, deployment
locations & host settings. These assumed [variable values](config.yml) can
easily be overridden.

Please note that tasks assume databases on relevant stages have already been
configured. If you need to skip all database operations, you can set
`skip_db_ops` to `true` [via the command line](https://deployer.org/docs/7.x/cli#overriding-configuration-options).

Run `vendor/bin/dep tree deploy` to view the `deploy` recipe tree.

Run `vendor/bin/dep deploy` to deploy.

Run `vendor/bin/dep` to review available recipes.

Please choose a platform to view related documentation.

* [Drupal](cms/drupal)
* [WordPress](cms/wp)

### Before/After Hooks
Deployer supports running tasks before or after other defined tasks. Defining
custom tasks to trigger before & after other defined tasks is trivial. Such
functionality can be added to the end of `deploy.yaml`, as shown below:

```yaml
tasks:
    foo:
        script:
            - "echo 'foo'"
    bar:
        script:
            - "echo 'bar'"

after:
    deploy:symlink: foo

before:
    deploy:unlock: bar
```

## References
* [Deployer 7 Documentation](https://deployer.org/docs/7.x/getting-started)
* [Default Deployer 7 Configuration](https://github.com/deployphp/deployer/blob/master/deploy.yaml)
* [Install and configure Deployer](https://lorisleiva.com/deploy-your-laravel-app-from-scratch/install-and-configure-deployer)
* [Create Your Own Deployer Recipes](https://lorisleiva.com/deploy-your-laravel-app-from-scratch/create-your-own-deployer-recipes)
