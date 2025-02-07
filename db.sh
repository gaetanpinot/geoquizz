#!/usr/bin/env bash

docker compose down game.db auth.db
docker compose up -d game.db auth.db
sleep 5
docker compose exec game php bin/console doctrine:migrations:migrate
docker compose exec game php bin/console doctrine:fixture:load
docker compose exec auth php bin/console doctrine:migrations:migrate
docker compose exec auth php bin/console doctrine:fixture:load
