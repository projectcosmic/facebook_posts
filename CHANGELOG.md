# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.0] 2020-11-12
### Changed
- Upgrade to Facebook graph version 9

### Fixed
- Fix post trimming sometimes deleting newer posts

## [1.1.6] 2020-06-02
### Added
- Declare Drupal 9 compatibility

### Fixed
- Fix incorrect `hook_uninstall()` implementation name

### Removed
- Remove `.gitattributes` from export

## [1.1.5] 2019-10-14
### Fixed
- Fix retry link

## [1.1.4] 2019-10-14
### Fixed
- Fix variable pollution

## [1.1.3] 2019-10-14
### Added
- Add logging channel
- Fetch on successful authentication

### Changed
- Use page text instead of redirect \w message

## [1.1.2] 2019-10-13
### Fixed
- Fix incorrect redirection

## [1.1.1] 2019-10-13
### Added
- Add update hook to delete removed config setting

## [1.1.0] 2019-10-11
### Added
- Add authentication flow for access tokens

### Fixed
- Fix cron schedule check

### Removed
- Remove unused function parameter

## 1.0.0
- Initial release

[Unreleased]: https://github.com/projectcosmic/facebook_posts/compare/1.2.0...HEAD
[1.2.0]: https://github.com/projectcosmic/facebook_posts/compare/v1.1.6...v1.2.0
[1.1.6]: https://github.com/projectcosmic/facebook_posts/compare/1.1.5...v1.1.6
[1.1.5]: https://github.com/projectcosmic/facebook_posts/compare/1.1.4...1.1.5
[1.1.4]: https://github.com/projectcosmic/facebook_posts/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/projectcosmic/facebook_posts/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/projectcosmic/facebook_posts/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/projectcosmic/facebook_posts/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/projectcosmic/facebook_posts/compare/1.0.0...1.1.0
