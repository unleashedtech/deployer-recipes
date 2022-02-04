# WordPress Deployer Config
Most WordPress-specific configuration is provided by the [WordPress Recipe](5.php), which must be imported _after_ your
initial configuration is defined. That recipe imports the [Main Config](../../config.php), which will fill in any config
gaps. Please review the files above to identify variables you'll be able to override if desired.

### Standard WordPress Configuration

You will need to define a little configuration for your project. Please review
the [main config file](../../config.php) for the list of default variable names & values.

The following will configure Deployer to deploy `bar@repository1.example:foo/wp`
to `foo.dev1.example`, `foo.staging1.example` & `production1.example`. You will be able to control all aspects of those values.

```yaml
config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    upload_dir: 'docroot/app/uploads'

import:
    - 'vendor/unleashedtech/deployer-recipes/cms/wp/5.php'
```

Many defaults are provided. You will need to define a few of them. Your configuration
may be as simple as:

```yaml
config:
    namespace: foo
    repository_domain: 'repository1.example'
    staging_domain: 'staging1.example'

import:
    - 'vendor/unleashedtech/deployer-recipes/cms/wp/5.php'
```
