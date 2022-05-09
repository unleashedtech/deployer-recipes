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
locations & host settings. These [assumed default values](config.php) are
only applied if you haven't already defined them. Please choose a platform
below for more.

* [Drupal](cms/drupal)
* [Magento](cms/magento)
* [WordPress](cms/wp)

Please note that tasks assume databases on relevant stages have already been
configured. If you need to skip all database operations, you can set
`skip_db_ops` to `true` [via the command line](https://deployer.org/docs/7.x/cli#overriding-configuration-options).

Run `vendor/bin/dep tree deploy` to view the `deploy` task tree.

Run `vendor/bin/dep deploy` to deploy.

Run `vendor/bin/dep` to review available tasks.

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

### SSH Hosts
This package will dynamically define hosts based on global configuration values.
It loops over a CSV list of environments in the `environments` variable, defining
0 or more hosts for each environment. By default, `production`, `staging` & `dev`
environments are defined. For each environment, the package defines a number of
hosts based on the integer value of the matching `{environment}_webservers`
variable (e.g. two hosts defined for `production` based on the `production_webservers`
variable value). These hosts will be linked together by their environment name
(or `stage`, in Deployer parlance). When you want to deploy to production, you would
probably run a command similar to `dep deploy stage=production`. This package assumes
there are 2 production webservers, by default.

```yaml
config:
    ####
    production_domain: 'production1.example'
    production_webservers: 3
```

#### Configuring SSH
The hosts defined by Deployer are merely aliases. During execution, Deployer will
assume hosts defined internally are available via SSH. You can add hosts to your
`~/.ssh/config` file, or you can add [Include](https://man.openbsd.org/ssh_config#Include)
directive(s) which will load config provided by other files into your main SSH config.
Such definitions can occur immediately before an automated deployment.

Each _project_ can provide its own SSH config. Consider creating an `.ssh` folder in your
project root & creating a `config` file within.

You can manually include config for _specific_ projects:
```
Include ~/projects/foo/.ssh/config
```

You can also use a pattern to auto-include project config from _many_ folders:
```
Include ~/projects/*/.ssh/config
```

## References
* [Deployer 7 Documentation](https://deployer.org/docs/7.x/getting-started)
* [Default Deployer 7 Configuration](https://github.com/deployphp/deployer/blob/master/deploy.yaml)
* [Install and configure Deployer](https://lorisleiva.com/deploy-your-laravel-app-from-scratch/install-and-configure-deployer)
* [Create Your Own Deployer Recipes](https://lorisleiva.com/deploy-your-laravel-app-from-scratch/create-your-own-deployer-recipes)
