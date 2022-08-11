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

install:
	composer install --no-interaction
	rm -rf .env
	cp .env.prod .env
	php artisan key:generate
	php artisan storage:link
	chmod -R 777 storage/ bootstrap/
	php artisan system:seed --base
	php artisan system:clear
	screen -dmS schedule php artisan schedule:work
	screen -dmS queue php artisan queue:work
	php putenv("APP_INSTALLED=true")

update:
	php artisan down
	composer install
	php artisan system:clear
	php artisan system:seed --base
	php artisan up
