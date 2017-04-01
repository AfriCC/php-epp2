#!/usr/bin/env bash

__DIR__="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# required libs
source "${__DIR__}/.bash/functions.shlib"

set -E
trap 'throw_exception' ERR

composer install \
  --no-interaction \
  --prefer-dist \
  --no-suggest

php_version="$(php --version | head -n1 | cut -d' ' -f2)"

# switch phpunit version depending on php version
if [[ "${php_version}" == 7.* ]]; then
  composer require --dev phpunit/phpunit
elif [[ "${php_version}" == 5.6.* ]]; then
  composer require --dev phpunit/phpunit '5.7.*'
else
  composer require --dev phpunit/phpunit '4.8.*'
fi
