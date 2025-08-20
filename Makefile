start:
	docker compose up -d --build

stop:
	docker compose down

install: start migrate fixtures assets

migrate:
	docker compose exec app php bin/console doctrine:database:create --if-not-exists || true
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	docker compose exec app php bin/console doctrine:fixtures:load --no-interaction || true

assets:
	npm install || true
	npm run build || true

tests:
	docker compose exec app php bin/phpunit

bash:
	docker compose exec app bash
