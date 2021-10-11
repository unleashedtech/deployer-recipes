# WordPress Deployer Config

## Examples
The following will configure Deployer to deploy `git@github.com:example/wp`
to `example.example.com`. It will expect that `example-staging` is a defined host.
```yaml
import:
  - "vendor/unleashedtech/deployer-recipes/cms/wp/5.yml"

config:
  application: 'example'
```
