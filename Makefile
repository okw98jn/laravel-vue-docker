# コンテナ起動
up:
	docker compose up -d

# コンテナ停止
down:
	docker compose down

# コンテナイメージボリューム削除
destroy:
	docker compose down --rmi all --volumes --remove-orphans

# コンテナビルド
build:
	docker compose build --no-cache --force-rm

# コンテナシェルログイン(laravel)
sh-backend:
	docker compose exec backend bash

# コンテナシェルログイン(vue)
sh-frontend:
	docker compose exec frontend bash

# コンテナシェルログイン(mysql)
sh-mysql:
	docker compose exec mysql bash

# git clone
laravel-install:
	docker compose exec backend composer install
	docker compose exec backend cp .env.example .env
	docker compose exec backend php artisan key:generate
	docker compose exec backend php artisan storage:link
	docker compose exec backend chmod -R 777 storage bootstrap/cache

# laravel create-project
laravel-create:
	docker compose exec backend composer create-project --prefer-dist laravel/laravel .
	docker compose exec backend php artisan key:generate
	docker compose exec backend php artisan storage:link
	docker compose exec backend chmod -R 777 storage bootstrap/cache

# composer install
composer-install:
	docker compose exec backend composer install

# laravelキャッシュクリア
clear:
	docker compose exec backend php artisan cache:clear
	docker compose exec backend php artisan config:clear
	docker compose exec backend php artisan route:clear
	docker compose exec backend php artisan view:clear

# migrate
migrate:
	docker compose exec backend php artisan migrate

# db:seed
seed:
	docker compose exec backend php artisan db:seed

# migrate:fresh
fresh:
	docker compose exec backend php artisan migrate:fresh

# npm create vue@latest
vue-install:
	docker compose exec frontend npm create vue@latest .

# npm install
npm-i:
	docker compose exec frontend npm install

# npm run dev
npm-d:
	docker compose exec frontend npm run dev