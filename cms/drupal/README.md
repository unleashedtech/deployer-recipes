# Drupal Deployer Config
Most Drupal-specific configuration is provided by the [Drupal Recipe](9.yml).
That recipe imports the [Main Config](../../config.yml). The default
configuration can be overridden by copying lines out of those files & placing
them under `config` in your project's `deploy.yaml` file. Please review the
files above to identify variables & default values that have been defined. The
default configuration can be overridden by copying lines out of those files &
placing them under `config` in the main `deploy.yaml` file.

### Standard Drupal Configuration

You will need to override some default configuration for your project.
Please review the [main config file](../../config.yml) for the list of default
variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/drupal`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`. You will be able to override all aspects of those values.

Note that the `writable_dirs` variable provided by the [Drupal recipe](9.yml)
is also being overridden.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/drupal/5.yml"

config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    writable_dirs:
        - 'docroot/sites/{{default_site}}/files'
```

Many defaults are provided. You will need to override a few of them.