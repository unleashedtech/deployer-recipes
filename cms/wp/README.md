# WordPress Deployer Config
Most WordPress-specific configuration is provided by the [WordPress Recipe](5.yml).
That recipe imports the [Main Config](../../config.yml). The `default`
configuration can be overridden by copying lines out of those files & placing
them under `config` in the main `deploy.yaml` file. Please review that configuration
to identify variables & default values that have been defined.

### Standard WordPress Configuration

You will need to override some default configuration for your project.
The following will configure Deployer to deploy `bar@repository1.example:foo/wp`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`. You will be able to override all aspects of those values.

Most of the variables being overridden are those defined in the [Main Config](../../config.yml).
The `upload_dir` variable provided by the [WordPress recipe](5.yml) is also
being overridden.

```yaml
import:
    - "vendor/unleashedtech/deployer-recipes/cms/wp/5.yml"

config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    upload_dir: 'docroot/app/uploads'
```

Many defaults are provided. You will need to override a few of them.
