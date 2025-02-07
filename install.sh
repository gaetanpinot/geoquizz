#!/bin/bash 
docker compose down
docker compose run --rm mailer composer install
docker compose run --rm game composer install
docker compose run --rm auth composer install
docker compose run --rm gateway composer install
docker compose run --rm front npm install
docker compose run --rm front npm run build
docker compose up -d
