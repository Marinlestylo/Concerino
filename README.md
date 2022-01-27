# Concer'ino

Le but du projet Concer'ino est de réaliser une application complète de base de données relationnelle. Cette application
permet de lister différents concerts dans toute la Suisse avec la possibilité d’indiquer sa présence. Ce projet a été
réalisé dans le cadre du cours BDR, par Jonathan Friedli, Stéphane Marengo et Loris Marzullo.

## Mode d'emploi

L'ensemble de l'infrastructure a été dockerisée et se configure dans le
fichier [docker-compose.yaml](docker-compose.yml).

### Prérequis

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Configuration

Le fichier [docker-compose.yml](docker-compose.yml) peut être modifié pour changer les ports utilisés par
l'infrastructure de la façon suivante:

```yaml
services:
  web:
    [ ... ]
    ports:
      - "<PORT_HÔTE>:80" # Page web
    [ ... ]
  db:
    [ ... ]
    ports:
      - "PORT_HÔTE:5432" # DB
    [ ... ]
```

Par défaut, les ports utilisés sont `9090` pour le serveur web et `6666` pour la base de données.

### Lancement & Arrêt

1. Effectuer un `docker-compose up -d`
    - La première exécution prend plus de temps car les images des containers doivent être téléchargées et construites
2. Accéder à `localhost:<PORT_HÔTE>` depuis un navigateur quelconque
    - où `<PORT_HÔTE>` correspond au port choisi pour le serveur web dans le fichier de configuration
    - sa valeur par défaut est `9090`
3. La base de données est accessible à l'adresse `localhost:<PORT_HÔTE>` avec les identifiants spécifiés précédemment
    - où `<PORT_HÔTE>` correspond au port choisi pour la BD
    - sa valeur par défaut est `6666`
    - les identifiants par défaut sont `postgres:admin`
    - le nom par défaut de la BD est `concerino`
4. L'infrastructure peut être arrêtée avec la commande `docker compose down`

### Persistance des données

Les données de la BD sont stockées dans un volume docker et sont donc peristantes entre les différents lancements. Pour
revenir aux données initiales, il suffit de supprimer le volume en question à l'aide de la
commande `docker volume rm concerino_pgdata` et de relancer l'infrastructure.

Les comptes disponibles sont les suivants :

| login          | mot de passe | modérateur |
| :------------- |:------------:| ---------: |
| a@gmail.com    | admin        | non        |
| b@gmail.com    | admin        | non        |
| c@gmail.com    | admin        | oui        |
| d@gmail.com    | admin        | oui        |
| e@gmail.com    | admin        | oui        |

## Bugs connus

* Si on va sur une page qui n'existe pas en étant co, on a le menu comme si on était pas co
* Pas de check pour s'inscrire ni delete (on pourrait check juste avant de le faire mais flemme)