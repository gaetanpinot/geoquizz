#!/usr/bin/env bash

docker compose exec game php bin/console doctrine:migrations:migrate
docker compose exec game php bin/console doctrine:fixture:load
docker compose exec auth php bin/console doctrine:migrations:migrate
docker compose exec auth php bin/console doctrine:fixture:load
