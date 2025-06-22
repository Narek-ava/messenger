# Makefile для Laravel + Docker проекта

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose up -d --build

bash:
	docker exec -it laravel_app bash

composer-install:
	docker exec -it laravel_app composer install

npm-install:
	docker exec -it laravel_app npm install

npm-dev:
	docker exec -it laravel_app npm run dev

migrate:
	docker exec -it laravel_app php artisan migrate

seed:
	docker exec -it laravel_app php artisan db:seed

artisan:
	docker exec -it laravel_app php artisan

fresh:
	docker exec -it laravel_app php artisan migrate:fresh --seed

logs:
	docker-compose logs -f app

test:
	docker exec -it laravel_app php artisan test


reverb:
	docker exec -it laravel_app php artisan reverb:start
