# Drupal Deployer Config

## Examples
The following will configure Deployer to deploy `git@github.com:example/drupal`
to `example.example.com`. It will expect that `example-staging` is a defined host.
```yaml
import:
  - "vendor/unleashedtech/deployer-recipes/cms/drupal/9.yml"

config:
  application: 'example'
```
