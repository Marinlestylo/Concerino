# Concer'ino
Le but du projet Concer'ino est de réaliser une application complète de base de données relationnelle. Cette application permet de lister différents
concerts dans toute la Suisse avec la possibilité d’indiquer sa présence

## Comment run ce projet:
* Installez la denière version de [php](https://www.sitepoint.com/how-to-install-php-on-windows/) dans **C:/.../php** (Il est important que le dossier s'appelle php et pas php-8.1 par exemple).
* Dans **C:/.../php/php.ini**, décommenter les lignes :
    * extension=pdo_pgsql
    * extension=pgsql
* Installez la dernière version de [postgres SQL](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)
* Installez [composer](https://getcomposer.org/)
* Modifiez le fichier config.php
* Dans le terminal: 
```js
cd D:\Concerino\src
composer dump-autoload // Il faut refaire ça dès qu'on crée un fichier/dossier
php -S localhost:8888 // ouvre un server local sur le port 8888
```


## Question à poser :
* Si l'utilisateur rentre de mauvaise donnée, doit-on mettre un message d'erreur ou juste rediriger sur la page de création ?
* Est-ce grave de select tout les champs si l'on utilise que un dans le html ? (ex: Lieu pour la création de concert).

### Bugs connus :
* Quand on a rempli le formulaire de création d'un concert, on est redirigé vers le tableau de tous les concerts mais l'url n'est pas update.
* On peut se logout quand on est pas login et on peut se relogin si on est login