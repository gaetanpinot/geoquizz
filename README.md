# SAE Geoquizz
## Groupe
- Sasha DAZA
- Mathis PERROT
- Gaëtan PINOT
- Yehor PRYKHODKO

## URLS:
- [Frontend](http://docketu.iutnc.univ-lorraine.fr:12100)
- [Mailcatcher](http://docketu.iutnc.univ-lorraine.fr:12107)

## Installation

`./install.bash`

### Remplir la base de donnée

`./db.sh`


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
- [x] Mailer
	- [x] queue rabbitmq
	- [x] service mailer


