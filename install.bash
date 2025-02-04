#!/bin/bash 
alias 'dc' ='docker compose'
dc up -d
dc exec game composer install
dc exec auth composer install
