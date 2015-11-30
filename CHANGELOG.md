# Changelog

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