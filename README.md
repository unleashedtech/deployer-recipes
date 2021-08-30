# Deployer Recipes
This package uses Deployer 7, which supports recipes defined by YAML or PHP.

Deployer will import the recipes linearly & merge them recursively. Deployer
looks for `deploy.php` or `deploy.yaml` when run.

## Examples
Recipes have been organized to easily support any version of any software.
The recipe makes several assumptions about git repository settings, deployment
locations & host settings. These assumed variable values can easily be
overridden by defining them in the `config` object below the `import` array.

```yaml
import:
  - "deploy/recipes/drupal/9.yml"

# Configure Deployer to deploy git@github.com:example/drupal to example.example.com 
config:
  application: 'example'
  staging_tld: 'example.com'
  git_repo_domain: 'github.com'
```

The recipe assumes that the host `example-staging` is defined.

## References
* <https://github.com/deployphp/deployer/blob/master/deploy.yaml>
* <https://lorisleiva.com/deploy-your-laravel-app-from-scratch/install-and-configure-deployer>
* <https://lorisleiva.com/deploy-your-laravel-app-from-scratch/create-your-own-deployer-recipes>
