# Changelog

## 1.0.0 - 2018-12-23

### Changes

- response will always be a result-array (_breaking_)

### Added

- `verify_peer_name` option (thx @panaceya)

### Fixed

- cz-nic (thx @krtcom)
- php 7.2+ compat (thx @krtcom)

## 0.3.1 - 2017-04-27

### Added

- `ExtensionInterface` now uses `getExtensionName` for a more cleaner
  interface (thx @jkaflik)
- added a lot of tests to improve code coverage

## 0.3.0 - 2017-04-02

### Added

- Implemented RFC3915 (thx @naja7host)
- `ContactTrait::skipLoc()` analogue to `ContactTrait::skipInt()` (thx @naja7host)

## 0.2.0 - 2017-04-01

### Added

- `Client` configurable buffer chunk size (thx @nidzho)
- `Frame/Hello` proper hello frame implementation (thx @bgentil)
- php7.1 support

### Fixed

- travis
- autoloader / phpunit

## 0.1.7 - 2016-07-17

### Added

- `Client` now also supports SSL passphrases (with local_cert) (thx @pavkatar)

## 0.1.6 - 2015-11-30

### Fixed

- return extension resData even if no main resData element in response (#16)

### Added

- `DomainInfo::setAuthInfo`: add (optional) authInfo on domain info queries (thx @johnny-bit)

## 0.1.5 - 2015-05-02

### Fixed

- some minor logical fixes and typos

### Added

- `DomainCreate::setBillingContact`: set billing contact while creating domains (thx @jbarbede)
- `DomainUpdate::addBillingContact`: add billing contact while updating domains (thx @jbarbede)
- `DomainUpdate::removeBillingContact`: remove billing contact while updating domains (thx @jbarbede)
- `Client::login`: add ability to passthrough svcExtensions via Client config (thx @jbarbede)
- `Transfer`: add query type operation
- NicMX Extension (thx @jbarbede)
