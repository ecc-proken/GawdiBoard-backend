DC := docker compose

up:
	$(DC) up -d
build:
	$(DC) build --no-cache --force-rm
laravel-install:
	$(DC) exec app composer create-project --prefer-dist laravel/laravel .
create-project:
	mkdir -p backend
	@make build
	@make up
	@make laravel-install
	$(DC) exec app php artisan key:generate
	$(DC) exec app php artisan storage:link
	$(DC) exec app chmod -R 777 storage bootstrap/cache
	@make fresh
install-recommend-packages:
	$(DC) exec app composer require doctrine/dbal
	$(DC) exec app composer require --dev ucan-lab/laravel-dacapo
	$(DC) exec app composer require --dev barryvdh/laravel-ide-helper
	$(DC) exec app composer require --dev beyondcode/laravel-dump-server
	$(DC) exec app composer require --dev barryvdh/laravel-debugbar
	$(DC) exec app composer require --dev roave/security-advisories:dev-master
	$(DC) exec app php artisan vendor:publish --provider="BeyondCode\DumpServer\DumpServerServiceProvider"
	$(DC) exec app php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
init:
	$(DC) up -d --build
	$(DC) exec app composer install
	$(DC) exec app cp .env.example .env
	$(DC) exec app php artisan key:generate
	$(DC) exec app php artisan storage:link
	$(DC) exec app chmod -R 777 storage bootstrap/cache
	@make fresh
remake:
	@make destroy
	@make init
stop:
	$(DC) stop
down:
	$(DC) down --remove-orphans
restart:
	@make down
	@make up
destroy:
	$(DC) down --rmi all --volumes --remove-orphans
destroy-volumes:
	$(DC) down --volumes --remove-orphans
ps:
	$(DC) ps
logs:
	$(DC) logs
logs-watch:
	$(DC) logs --follow
log-web:
	$(DC) logs web
log-web-watch:
	$(DC) logs --follow web
log-app:
	$(DC) logs app
log-app-watch:
	$(DC) logs --follow app
log-db:
	$(DC) logs db
log-db-watch:
	$(DC) logs --follow db
web:
	$(DC) exec web ash
app:
	$(DC) exec app bash
migrate:
	$(DC) exec app php artisan migrate
fresh:
	$(DC) exec app php artisan migrate:fresh --seed
seed:
	$(DC) exec app php artisan db:seed
dacapo:
	$(DC) exec app php artisan dacapo
rollback-test:
	$(DC) exec app php artisan migrate:fresh
	$(DC) exec app php artisan migrate:refresh
tinker:
	$(DC) exec app php artisan tinker
test:
	$(DC) exec app php artisan test
optimize:
	$(DC) exec app php artisan optimize
optimize-clear:
	$(DC) exec app php artisan optimize:clear
cache:
	$(DC) exec app composer dump-autoload -o
	@make optimize
	$(DC) exec app php artisan event:cache
	$(DC) exec app php artisan view:cache
cache-clear:
	$(DC) exec app composer clear-cache
	@make optimize-clear
	$(DC) exec app php artisan event:clear
db:
	$(DC) exec db bash
sql:
	$(DC) exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
redis:
	$(DC) exec redis redis-cli
ide-helper:
	$(DC) exec app php artisan clear-compiled
	$(DC) exec app php artisan ide-helper:generate
	$(DC) exec app php artisan ide-helper:meta
	$(DC) exec app php artisan ide-helper:models --nowrite
