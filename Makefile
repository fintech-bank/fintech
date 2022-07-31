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
	composer install
	rm -rf .env
	cp .env.prod .env
	php artisan key:generate
	php artisan storage:link
	chmod -R 777 storage/ bootstrap/
	php artisan system:seed --base --test
	php artisan system:clear
	screen -S <schedule> -X stuff 'php artisan schedule:work'
	screen -S <queue> -X stuff 'php artisan queue:work'

update:
	php artisan down
	composer install
	php artisan system:clear
	php artisan system:seed --base --test
	php artisan up
