# SAE Geoquizz
## Groupe
- Sasha DAZA
- Mathis PEROT
- Gaëtan PINOT
- Yehor PRYKHODKO

## Fonctionnalités
- Frontend 
    - Style : Sasha et Mathis
    - Fonctionnalités : Mathis
        - Gestion de la création d'une partie : Mathis
        - Jouer un coup et voir la différence entre l'estimation et la réalite : Mathis
        - Voir l'historique du joueur connécté : Mathis
- Backend 
    - Gateway : Gaëtan
    - Auth : Gaëtan 
    - Directus : Gaëtan
    - Service de mailer + file de message : Gaëtan
    - Fonctionnalités de jeux : Yehor
        - Token unique à la partie : Gaëtan
        - Création des parties : Yehor
        - Jouer une partie : Yehor
        - Historique des parties d'un joueur : Yehor
- Deployment sur Docketu: Gaëtan

## URLS:
- [Frontend](http://docketu.iutnc.univ-lorraine.fr:12100)
- [Mailcatcher](http://docketu.iutnc.univ-lorraine.fr:12107)
- [Gateway](http://docketu.iutnc.univ-lorraine.fr:12101)
- [Directus](http://docketu.iutnc.univ-lorraine.fr:12102)

## Installation
Il faut copier les fichiers `*env.dist` en `*env`  
Il y a un script `cpenv.sh` qui copie les fichiers `.env` nécéssaire pour un fonctionnement basique.
Le fichier `.env` contient les ports sur lequel seront déployé l'application.  
Certain fichier d'env contienne des secret pour encoder du jwt ou des tokens pour acceder a des application.
Il serat peut être nécéssaire de modifier certaines valeurs pour que l'application fonctionne bien.

Executer `./install.bash`  
Puis créer la base de donnée avec `./db.sh`
