EXEC=docker compose exec
EXEC_WD=$(EXEC) -u www-data app
EXEC_ROOT=$(EXEC) app

start:
	docker compose up -d --build

stop:
	docker compose down -v

install: start composer-install migrate fixtures

composer-install:
	$(EXEC_WD) composer install --no-interaction --prefer-dist

migrate:
	$(EXEC_WD) php bin/console doctrine:database:create --if-not-exists || true
	$(EXEC_WD) php bin/console doctrine:migrations:migrate -n

fixtures:
	$(EXEC_WD) php bin/console doctrine:fixtures:load -n || true

test:
	docker compose exec -u www-data -e APP_ENV=test app php bin/phpunit

reset-db:
	$(EXEC_WD) rm -f var/data.db || true
	$(EXEC_WD) php bin/console doctrine:database:create --if-not-exists
	$(EXEC_WD) php bin/console doctrine:migrations:migrate -n
	$(EXEC_WD) php bin/console doctrine:fixtures:load -n

fix-perms:
	$(EXEC_ROOT) chown -R www-data:www-data /var/www/var
	$(EXEC_ROOT) chmod -R 775 /var/www/var

bash:
	$(EXEC_ROOT) bash
