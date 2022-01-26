# Concer'ino
Le but du projet Concer'ino est de réaliser une application complète de base de données relationnelle. Cette application permet de lister différents
concerts dans toute la Suisse avec la possibilité d’indiquer sa présence. Ce projet a été réalisé dans le cadre du cours BDR, par Jonathan Friedli, Stéphane Marengo et Loris Marzullo.

## Comment run ce projet:
Ce projet utilise docker afin de faciliter l'installtion des différentes dépendance de ce projet (Postgres, Php, composer).
* Pour installer Docker [cliquez-ici](https://docs.docker.com/get-docker/)
* Allez à la racine du projet, au niveau du fichier docker-compose.yml et faites ```docker-compose build```
* Ensuite faites ```docker-compose up -d```
* Ouvrez maintenant un navigateur web et entrez l'adresse suivante : [localhost:9090](http://localhost:9090/)
* Pour éteindre l'application web: ```docker-compose down```

Le site web est déjà peuplé avec des données de base. Tous les ajouts fait via l'application web seront permanent. Si vous souhaitez revenir à l'état de base: Commencez par éteindre l'application, puis effectuez la commande suivante: ```docker volume rm concerino_pgdata```  
Ensuite ```docker-compose build``` et enfin ```docker-compose up -d```

Comptes déjà créés :
|    login     | mot de passe |
| -------------|-------------:|
| a@gmail.com  |    admin     |
| b@gmail.com  |    admin     |
| c@gmail.com  |    admin     |
| d@gmail.com  |    admin     |
| e@gmail.com  |    admin     |


## Question à poser :
* Si l'utilisateur rentre de mauvaise donnée, doit-on mettre un message d'erreur ou juste rediriger sur la page de création ?
* Est-ce grave de select tout les champs si l'on utilise que un dans le html ? (ex: Lieu pour la création de concert).
* https://stackoverflow.com/questions/1616123/sql-query-to-get-all-values-a-enum-can-have comment avoir toutes les valeurs d'une enum.

### Bugs connus :
* Si on va sur une page qui n'existe pas en étant co, on a le menu comme si on était pas co