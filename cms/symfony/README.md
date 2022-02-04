# Symfony Deployer Config
Most Symfony-specific configuration is provided by the [Symfony Recipe](5.yml).
That recipe imports the [Main Config](../../config.php). The default
configuration can be overridden by copying lines out of those files & placing
them under `config` in your project's `deploy.yaml` file. Please review the
files above to identify variables & default values that have been defined. The
default configuration can be overridden by copying lines out of those files &
placing them under `config` in the main `deploy.yaml` file.

### Standard Symfony Configuration

You will need to override some default configuration for your project.
Please review the [main config file](../../config.php) for the list of default
variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/symfony`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`. You will be able to override all aspects of those values.

```yaml
config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example'
    dev_domain: 'dev1.example'
    staging_domain: 'staging1.example'
    production_domain: 'production1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/platform/symfony/9.yml'
```

Many defaults are provided. You will need to override a few of them. Your configuration
may be as simple as:

```yaml
config:
    namespace: foo
    repository_domain: 'repository1.example'
    staging_domain: 'staging1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/platform/symfony/9.yml'
```
