#!/bin/bash 
alias docker compose = 'dc'
dc up -d
dc exec game composer install
