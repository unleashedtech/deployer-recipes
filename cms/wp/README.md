# WordPress Deployer Config

## Example WordPress Configuration

The following will configure Deployer to deploy `git@repository.example:foo/wp`
to `foo.dev.example`, `foo.staging.example` & `production.example`. It will
expect that `example-staging` is a [defined host](https://www.ssh.com/academy/ssh/config#format-of-ssh-client-config-file-ssh_config).

Most WordPress-specific configuration is provided by the [WordPress Recipe](5.yml).
That recipe imports the [Main Config](../../config.yml). The default
configuration can be overridden by copying lines out of those files & placing
them under `config` in the main `deploy.yaml` file.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/wp/5.yml"

config:
    application: foo
```

### Standard WordPress Configuration

You will need to provide a little more information for your project.
Please review the [main config file](../../config.yml) for the list of default
variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/wp`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`.

Note that the `upload_dir` variable provided by the [WordPress recipe](5.yml)
is also being overridden.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/wp/5.yml"

config:
    application: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    upload_dir: 'docroot/app/uploads'
```

Many defaults are provided. You will need to override a few of them.
