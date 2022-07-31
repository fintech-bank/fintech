.PHONY: helpers
helpers:
	php artisan ide-helper:generate
	php artisan ide-helper:models -F helpers/ModelHelper.php -M
	php artisan ide-helper:meta

pint:
	./vendor/bin/pint

all:
	make helpers
	make pint
