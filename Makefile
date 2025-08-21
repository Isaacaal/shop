EXEC=docker compose exec
EXEC_WD=$(EXEC) -u www-data -w /var/www app
EXEC_ROOT=$(EXEC) -w /var/www app

start:
	docker compose up -d --build

stop:
	docker compose down -v

install: start git-safe fix-perms composer-install migrate fixtures

git-safe:
	$(EXEC_ROOT) git config --system --add safe.directory /var/www || true

fix-perms:
	$(EXEC_ROOT) mkdir -p var vendor public/bundles public/uploads assets
	$(EXEC_ROOT) chown -R www-data:www-data var vendor public assets
	$(EXEC_ROOT) chmod -R 775 var vendor public assets

composer-install:
	$(EXEC_WD) composer install --no-interaction --prefer-dist

migrate:
	$(EXEC_WD) php bin/console doctrine:database:create --if-not-exists || true
	$(EXEC_WD) php bin/console doctrine:migrations:migrate -n

fixtures:
	$(EXEC_WD) php bin/console doctrine:fixtures:load -n || true

test:
	$(EXEC) -u www-data -e APP_ENV=test -w /var/www app php bin/phpunit

reset-db:
	$(EXEC_WD) rm -f var/data.db || true
	$(EXEC_WD) php bin/console doctrine:database:create --if-not-exists
	$(EXEC_WD) php bin/console doctrine:migrations:migrate -n
	$(EXEC_WD) php bin/console doctrine:fixtures:load -n

bash:
	$(EXEC_ROOT) bash
