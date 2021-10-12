# WordPress Deployer Config

## Examples

The following will configure Deployer to deploy `git@github.com:example/sample-wp`
to `example123.com` (dev) and `production123.com` (production).
It will expect that `example-staging` is a defined host.

For other variables defined see
- [Main Config](https://github.com/unleashedtech/deployer-recipes/blob/main/config.yml)

```yaml
import:
  - "vendor/unleashedtech/deployer-recipes/cms/wp/5.yml"

config:
  application: example
  project: sample-wp
  repository_domain: github.com
  shared_files: [.env]
  shared_dirs: [web/app/uploads]
  writable_dirs: [web/app/plugins/all-in-one-wp-migration/storage, web/app/uploads, web/app/ai1wm-backups ]
  wp: '{{bin}}/wp'
  dev_domain: example123.com
  Production_domain: production123.com
  Production_deploy_path: '{{deploy_root}}/{{production_domain}}'
```
