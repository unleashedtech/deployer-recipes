# Drupal Deployer Config

Most Drupal-specific configuration is provided by the [Drupal Recipe](9.yml), which must be imported _after_ your
initial configuration is defined. That recipe imports the [Main Config](../../config.php), which will fill in any config
gaps. Please review the files above to identify variables you'll be able to override if desired.

## Standard Drupal Configuration

You will need to define a little configuration for your project. Please review
the [main config file](../../config.php) for the list of default variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/drupal`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`. You will be able to control all aspects of those
values.

```yaml
config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example'
    dev_domain: 'dev1.example'
    staging_domain: 'staging1.example'
    production_domain: 'production1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/cms/drupal/9.yml'
```

Many defaults are provided. Your configuration may be as simple as:

```yaml
config:
    namespace: foo
    repository_domain: 'repository1.example'
    staging_domain: 'staging1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/cms/drupal/9.yml'
```

This package supports configuration of Drupal via Environment Variables by default.
Please consider using Unleashed Technologies' [dotenv-drupal](https://packagist.org/packages/unleashedtech/dotenv-drupal)
package to help streamline your Drupal configuration process.

## Drupal Multi-Site Support

A Drupal application may support more than one site. The default [Drupal Deployer config](9.yml) defines a
global `sites` array, with just one item:
`default`. Shared directories & files, as well as writable directories are defined by looping through the list of
defined sites. If you have more than one site provided by Drupal in your project, you'll need to override the
`sites` array with your list of sites:

```yaml
config:
    ######
    sites:
        - foo
        - bar
        - baz
        - qux
```

The list of directory names & file names are provided by default. They can be overridden as well:

```yaml
config:
    #################
    shared_dir_names:
        - my_files
    shared_file_names:
        - 'settings.php'
        - 'settings.local.php'
        - 'settings.foo.php'
        - 'services.yml'
    writable_dir_names:
        - my_files
```
