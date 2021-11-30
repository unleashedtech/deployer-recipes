# Change Log
All notable changes to this project will be documented in this file.
Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [Unreleased][unreleased]

## [0.2.0] - 2021-11-30

### Changed

#### Drupal

- `shared_file_names` now defaults to a single value referencing an `.env` file. The
  variable can be overridden if standard-fare Drupal configuration via settings files
  is preferred. See [unleashedtech/dotenv-drupal](https://github.com/unleashedtech/dotenv-drupal) for more.
- `shared_dir_names`, `shared_file_names` & `writable_dir_names` now require arrays of
  paths relative to the release root. Each path will be parsed for placeholders before use.
- The `cms:drupal:db:backup:create` task now supports creating backups of multi-site apps.

### Fixed

#### Drupal

- Database backup(s) are created at the outset of the `deploy` task to help ensure reliability
  of the database backup task.

## [0.1.9] - 2021-11-03

### Fixed

- Restoring squashed essential Drupal multi-site variables.

## [0.1.8] - 2021-11-03

### Fixed

- Missing Drupal-init-related import issue fixed.
- YAML script syntax issues resolved.

## [0.1.7] - 2021-11-03

### Changed

- Added Drupal multi-site support.
- Removed database fail-over functionality & added related documentation.
- Renaming keep_backups variable name to backups_limit. Related refactoring.
- Revising dependency version requirements.
- Created releases:cleanup task, which addresses contrib writable files permissions issue.

### Fixed

- Fixed additional database backup issue related to standardization of db:backup:download recipes.

## [0.1.6] - 2021-10-25

### Fixed

- Fixed database backup issue related to standardization of db:backup:download recipes.

## [0.1.5] - 2021-10-13

### Changed

- "application" variable changed to "namespace".
- "project" variable defined.
- WordPress CMS support added.
- Global host-related config variable names were changed to better describe their values.
- Staging & production "stages" were added & related global config variables defined.
- Documentation updated.
- Database cleanup task made generic.

## [0.1.4] - 2021-09-20

### Changed

- Created new composer:install task to allow custom Composer install options.

## [0.1.3] - 2021-09-17

### Fixed

- Resolving local database backup issues for Macs.

## [0.1.2] - 2021-09-16

### Changed

- Defining variables pertaining to local backup file locations.
- Defining deploy_root & staging_deploy_path variables to allow greater flexibility concerning the staging host config.

### Fixed

- Resolving many local database backup issues.

## [0.1.1] - 2021-08-31

### Changed

- Reorganized recipes
- Updated Drupal 8 config to make settings.local.php a shared file
- Updated db backup recipe to use gunzip and drush
- Made main recipe more generic
- Updated documentation

### Fixed

- Fixed autoloader config

## [0.1.0] - 2021-08-30

**Initial release!**

[unreleased]: https://github.com/unleashedtech/deployer-recipes/compare/0.2.0...main
[0.1.9]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.9...0.2.0
[0.1.9]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.8...0.1.9
[0.1.8]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.7...0.1.8
[0.1.7]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.6...0.1.7
[0.1.6]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.5...0.1.6
[0.1.5]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.4...0.1.5
[0.1.4]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.3...0.1.4
[0.1.3]: https://github.com/unleashedtech/deployer-recipes/compare/v0.1.2...0.1.3
[0.1.2]: https://github.com/unleashedtech/deployer-recipes/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/unleashedtech/deployer-recipes/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/unleashedtech/deployer-recipes/releases/tag/v0.1.0
