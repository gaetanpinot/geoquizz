#!/bin/bash 
docker compose down
docker compose run --rm mailer composer install
docker compose run --rm game composer install
docker compose run --rm auth composer install
docker compose run --rm gateway composer install
docker compose up -d
# docker compose exec game composer install
# docker compose exec auth composer install
# docker compose exec gateway composer install
docker compose exec game php bin/console doctrine:migrations:migrate
docker compose exec game php bin/console doctrine:fixture:load
docker compose exec auth php bin/console doctrine:migrations:migrate
docker compose exec auth php bin/console doctrine:fixture:load
