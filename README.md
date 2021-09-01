# UT Deployer Recipes

[![Latest Version](https://img.shields.io/packagist/v/unleashedtech/deployer-recipes.svg?style=flat-square)](https://packagist.org/packages/unleashedtech/deployer-recipes)
[![Software License](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/unleashedtech/deployer-recipes/test/main.svg?style=flat-square)](https://github.com/unleashedtech/deployer-recipes/actions?query=workflow%3Atest+branch%3Amain)

This package uses Deployer 7, which supports recipes defined by YAML or PHP.

Deployer will import the recipes linearly & merge them recursively. Deployer
looks for `deploy.php` or `deploy.yaml` when run.

## Examples
Recipes have been organized to easily support any version of any software.
They make several assumptions about git repository settings, deployment
locations & host settings. These assumed variable values can easily be
overridden by defining them in the `config` object below the `import` array.
Please see [config.yml](config.yml) for more.

The following will configure Deployer to deploy git@github.com:example/drupal
to example.example.com. It will expect that `example-staging` is a defined host.
```yaml
import:
  - "vendor/unleashedtech/deployer-recipes/cms/drupal/9.yml"

config:
  application: 'example'
```

## References
* <https://github.com/deployphp/deployer/blob/master/deploy.yaml>
* <https://lorisleiva.com/deploy-your-laravel-app-from-scratch/install-and-configure-deployer>
* <https://lorisleiva.com/deploy-your-laravel-app-from-scratch/create-your-own-deployer-recipes>
