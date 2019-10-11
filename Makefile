.PHONY: help vendor

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'


test-coverage: vendor ## run tests with coverage
	vendor/bin/phpunit --configuration=phpunit.xml.dist --coverage-text


test: vendor ## run tests
	vendor/bin/phpunit --configuration=phpunit.xml.dist


vendor: composer.json composer.lock ## update composer, validate and install it requirements
	composer self-update
	composer validate
	composer install


update: ## composer update requirements
	composer update