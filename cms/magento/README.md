# Magento Deployer 7 Config

```yaml
import:
    - 'vendor/unleashedtech/deployer-recipes/cms/magento/magento2.php'

config:
    namespace: foo
    repository_user: bar
    repository_domain: 'repository1.example`
    dev_domain: 'dev1.example`
    staging_domain: 'staging1.example`
    production_domain: 'production1.example`
    upload_dir: 'docroot/app/uploads'
```

Many defaults are provided. You will need to override a few of them. Your configuration
may be as simple as:

```yaml
import:
    - 'vendor/unleashedtech/deployer-recipes/cms/magento/magento2.php'

config:
    namespace: foo
    repository_domain: 'repository1.example'
    staging_domain: 'staging1.example'
```

[Magento2 Deployment Strategies and Discussions](https://magento.stackexchange.com/questions/315786/magento-2-configuration-settings-clarify-appconfigdump-vs-appconfigimport)
