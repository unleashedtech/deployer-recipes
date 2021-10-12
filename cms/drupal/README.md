# Drupal Deployer Config

## Example Drupal Configuration

The following will configure Deployer to deploy `git@repository.example:foo/drupal`
to `foo.dev.example`, `foo.staging.example` & `production.example`. It will
expect that `example-staging` is a [defined host](https://www.ssh.com/academy/ssh/config#format-of-ssh-client-config-file-ssh_config).

Most Drupal-specific configuration is provided by the [Drupal Recipe](9.yml).
That recipe imports the [Main Config](../../config.yml). The default
configuration can be overridden by copying lines out of those files & placing
them under `config` in the main `deploy.yaml` file.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/drupal/9.yml"

config:
    application: foo
```

### Standard Drupal Configuration

You will need to provide a little more information for your project.
Please review the [main config file](../../config.yml) for the list of default
variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/drupal`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`.

Note that the `writable_dirs` variable provided by the [Drupal recipe](9.yml)
is also being overridden.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/drupal/5.yml"

config:
    application: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    writable_dirs:
        - 'docroot/sites/{{drupal_site}}/files'
```

Many defaults are provided. You will need to override a few of them.
