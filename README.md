# SAE Geoquizz
## Groupe
- Sasha DAZA
- Mathis PERROT
- Gaëtan PINOT
- Yehor PRYKHODKO

## Installation

```bash
docker compose up -d
docker compose exec game composer install
docker compose exec auth composer install
```

### Remplir la base de donnée

```bash
docker compose exec game php bin/console doctrine:migrations:migrate
docker compose exec game php bin/console doctrine:fixture:load
docker compose exec auth php bin/console doctrine:migrations:migrate
docker compose exec auth php bin/console doctrine:fixture:load
```


## TODO:
- [x] Micro service de backoffice, gestion des photos et séries:
	- [x] Mise en place de directus
	- [x] Création des collections
- [x] Gateway
	- [x] Authentification
	- [x] Gestion des photos et séries
	- [x] Gestion des parties
- [x] Micro service d'authentification
	- [x] Login
	- [x] Register
	- [x] ValidateToken
	- [x] Get info utilisateur
- [ ] Micro service du jeu	
	- [ ] Création de la partie
- [ ] Mailer
	- [ ] queue rabbitmq
	- [ ] service mailer


