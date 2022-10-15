SHELL := bash


.PHONY: all
all:


.PHONY: build
build:
	composer install \
		--no-interaction \
		--prefer-dist


.PHONY: test
test:
ifeq ($(RUN_COVERAGE),true)
	mkdir -p build/logs
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text --coverage-clover build/logs/clover.xml
	vendor/bin/php-coveralls --quiet
else
	vendor/bin/phpunit
endif
