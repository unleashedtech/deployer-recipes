# Change Log

All notable changes to this project will be documented in this file.
Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [Unreleased][unreleased]

## [0.5.0] - 2022-10-25

### Changed

- Added read_only "harden" perms tool.
- Smaller revision values for backups and releases.

### Fixed

- Database and release cleanup passes.

## [0.4.0] - 2022-06-24

### Changed

- Updated Magento recipe shared dirs & files directives to better support
    Magento's Git restrictions.
- Deployer and Composer deprecated the dist install and with this change they
    also changed what exists in the vendor/bin directory. Deployer.phar is in
    vendor/bin instead of dep. All calls (in scripts) to deployer should be
    changed accordingly. This change gets rid of the composer deprecation warning
    that showed up during composer installs.
- Add 30 minute timeout to magento2 commands.

#### Removed

-   vendor/bin/dep is now vendor/bin/deployer.phar

## [0.3.23] - 2022-03-25

### Fixed

-   Fixed missing local host labels issue.

## [0.3.22] - 2022-03-15

### Fixed

-   Removing unnecessary `shared_files` item in the Magento 2 recipe.

## [0.3.21] - 2022-03-15

### Fixed

-   Adding `pub/static` to Magento 2 shared directories list & simplifying the list.
-   Removing all `writable_dirs` directives in Magento 2 recipe.
-   Removing `deploy:unlock` from `magento:init` task.
-   Updating `fill` function to support `int` & `boolean` defined values.

## [0.3.20] - 2022-03-10

### Changed

-   Updated Drupal recipes to better support multi-site DB pull operations.
-   Added `dev:sites` task which outputs the list of defined sites.
-   Defined a pair of local hosts.
-   Updating `cms:drupal:db:backup:create` to use project name in backup.

### Fixed

-   Fixing cms:drupal:db:backup:create to handle grep count error status code.

## [0.3.19] - 2022-02-03

### Changed

-   Added ClientInterface::getClientTimeout method. Related refactoring so Docksal
    uses the result of ClientInterface::getDefaultTimeout when running a command.

### Fixed

-   Restoring cms:drupal:pre:deploy to run the `composer:install` Deployer task rather
    than the `composer install` command.
-   Removed functions.php autoload reference.

## [0.3.18] - 2022-02-03

### Fixed

-   Temporarily removing automatic deploy failure unlock functionality due to order of operations issue.

## [0.3.17] - 2022-02-03

### Fixed

-   Fixing `fill` unsupported function type hint issue.

## [0.3.16] - 2022-02-03

### Changed

-   Revising main config to auto-unlock following a failure.

### Fixed

-   Revising `cms:drupal:db:backup:create` to allow each DB backup command an hour to execute, by default.

## [0.3.15] - 2022-02-02

### Changed

-   New Magento 2 recipe.

## [0.3.14] - 2022-02-01

### Changed

-   Revising `cms:drupal:db:update` to allow each DB update command an hour to execute, by default.

## [0.3.13] - 2022-01-27

### Changed

-   Revising `releases:cleanup` task so releases may be made writable before removal, if desired.

## [0.3.12] - 2022-01-25

### Changed

-   Adding `config.local.php`, `databases.local.php` & `settings.local.php` to list of shared file names.

## [0.3.11] - 2022-01-24

### Changed

-   Setting writable_dir_names to an empty array by default.
-   Removing writable_mode & writable_use_sudo default value overrides.

### Fixed

-   Resolving release_name setting issue.

## [0.3.10] - 2022-01-24

### Changed

-   Set writable_use_sudo to true by default.

### Fixed

-   Updated default shared_dir_names value to match writable_dir_names value.

## [0.3.9] - 2022-01-24

### Changed

-   Added ability to override config provided by contrib recipes.
-   Set writable_mode to chmod by default.

## [0.3.8] - 2022-01-21

### Fixed

-   Added automatic GTID purged variable support detection.

## [0.3.7] - 2022-01-21

### Changed

-   Updated VirtualMachine class to load a Virtual Machine Client class that implements an interface.

### Fixed

-   Resolved GTID issue preventing databases from being imported.

## [0.3.6] - 2022-01-21

Duplicate of 0.3.5.

## [0.3.5] - 2022-01-21

### Fixed

-   Revising Drupal private & temporary file paths to be relative in list of `writable_dir_names`.

## [0.3.4] - 2022-01-20

### Changed

-   Defined Drupal private & temporary file paths in default list of `writable_dir_names`.

## [0.3.3] - 2021-12-15

### Changed

-   Added the value of `{project}` to the default `{environment}_name` variable value to help prevent
    host name collisions among similar projects.

## [0.3.2] - 2021-12-15

### Fixed

-   Revised Drupal multi-site config to prevent project-specific variables from being overridden.
-   Updated WordPress config to be compatible with newer config default values logic.

## [0.3.1] - 2021-12-10

### Fixed

-   Revised relevant recipes to be compatible with 7.0.0-rc.3.
-   Defining CMS `deploy` task _after_ the majority of the recipes are loaded.
-   `fill` function `trim` compatibility bug fixed.
-   Revised `release_name` closure to return a string based on timestamp & branch if necessary.

## [0.3.0] - 2021-12-09

This release adds support for multiple production webservers. In order for such
functionality to work, the order of operations for the main `deploy.yaml` file needed
to be modified. Instead of importing the CMS-related recipe _early_ in the file, it
_must_ be imported _late_. This allows contrib recipes to _react_ to any config
that was defined earlier by `deploy.yaml`. The earlier approach only allowed global
config vars to be overridden.

### Changed

-   Updated package to use Deployer 7.0.0 release candidate 3.
-   Added support for multiple production webservers.
-   Revised package to load `config.php` _late_, instead of `config.yml` _early_.

## [0.2.1] - 2021-12-03

### Changed

-   Added `skip_db_ops` option to allow skipping of all DB-related operations.
-   Added `skip_db_backup` option to allow skipping of DB backup operations.

#### Drupal

-   Added `skip_cache_rebuild` option to allow skipping of cache rebuild operations.
-   Added `skip_config_import` option to allow skipping of config import operations.
-   Added `skip_db_update` option to allow skipping of DB update operations.
-   Added `skip_themes_build` option to allow skipping of theme build operations.
-   Multi-site support for `cms:drupal:cache:rebuild`.
-   Multi-site support for `cms:drupal:config:import`.
-   Multi-site support for `cms:drupal:db:update`.

## [0.2.0] - 2021-11-30

### Changed

#### Drupal

-   `shared_file_names` now defaults to a single value referencing an `.env` file. The
    variable can be overridden if standard-fare Drupal configuration via settings files
    is preferred. See [unleashedtech/dotenv-drupal](https://github.com/unleashedtech/dotenv-drupal) for more.
-   `shared_dir_names`, `shared_file_names` & `writable_dir_names` now require arrays of
    paths relative to the release root. Each path will be parsed for placeholders before use.
-   The `cms:drupal:db:backup:create` task now supports creating backups of multi-site apps.

### Fixed

#### Drupal

-   Database backup(s) are created at the outset of the `deploy` task to help ensure reliability
    of the database backup task.

## [0.1.9] - 2021-11-03

### Fixed

-   Restoring squashed essential Drupal multi-site variables.

## [0.1.8] - 2021-11-03

### Fixed

-   Missing Drupal-init-related import issue fixed.
-   YAML script syntax issues resolved.

## [0.1.7] - 2021-11-03

### Changed

-   Added Drupal multi-site support.
-   Removed database fail-over functionality & added related documentation.
-   Renaming keep_backups variable name to backups_limit. Related refactoring.
-   Revising dependency version requirements.
-   Created releases:cleanup task, which addresses contrib writable files permissions issue.

### Fixed

-   Fixed additional database backup issue related to standardization of db:backup:download recipes.

## [0.1.6] - 2021-10-25

### Fixed

-   Fixed database backup issue related to standardization of db:backup:download recipes.

## [0.1.5] - 2021-10-13

### Changed

-   "application" variable changed to "namespace".
-   "project" variable defined.
-   WordPress CMS support added.
-   Global host-related config variable names were changed to better describe their values.
-   Staging & production "stages" were added & related global config variables defined.
-   Documentation updated.
-   Database cleanup task made generic.

## [0.1.4] - 2021-09-20

### Changed

-   Created new composer:install task to allow custom Composer install options.

## [0.1.3] - 2021-09-17

### Fixed

-   Resolving local database backup issues for Macs.

## [0.1.2] - 2021-09-16

### Changed

-   Defining variables pertaining to local backup file locations.
-   Defining deploy_root & staging_deploy_path variables to allow greater flexibility concerning the staging host config.

### Fixed

-   Resolving many local database backup issues.

## [0.1.1] - 2021-08-31

### Changed

-   Reorganized recipes
-   Updated Drupal 8 config to make settings.local.php a shared file
-   Updated db backup recipe to use gunzip and drush
-   Made main recipe more generic
-   Updated documentation

### Fixed

-   Fixed autoloader config

## [0.1.0] - 2021-08-30

**Initial release!**

[unreleased]: https://github.com/unleashedtech/deployer-recipes/compare/0.5.0...main
[0.5.0]: https://github.com/unleashedtech/deployer-recipes/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.24...0.4.0
[0.3.24]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.23...0.3.24
[0.3.23]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.22...0.3.23
[0.3.22]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.21...0.3.22
[0.3.21]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.20...0.3.21
[0.3.20]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.19...0.3.20
[0.3.19]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.18...0.3.19
[0.3.18]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.17...0.3.18
[0.3.17]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.16...0.3.17
[0.3.16]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.15...0.3.16
[0.3.15]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.14...0.3.15
[0.3.14]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.13...0.3.14
[0.3.13]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.12...0.3.13
[0.3.12]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.11...0.3.12
[0.3.11]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.10...0.3.11
[0.3.10]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.9...0.3.10
[0.3.9]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.8...0.3.9
[0.3.8]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.7...0.3.8
[0.3.7]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.6...0.3.7
[0.3.6]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.5...0.3.6
[0.3.5]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.4...0.3.5
[0.3.4]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.3...0.3.4
[0.3.3]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.2...0.3.3
[0.3.2]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.1...0.3.2
[0.3.1]: https://github.com/unleashedtech/deployer-recipes/compare/0.3.0...0.3.1
[0.3.0]: https://github.com/unleashedtech/deployer-recipes/compare/0.2.1...0.3.0
[0.2.1]: https://github.com/unleashedtech/deployer-recipes/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/unleashedtech/deployer-recipes/compare/0.1.9...0.2.0
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
