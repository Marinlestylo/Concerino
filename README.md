# Concer'ino
Le but du projet Concer'ino est de réaliser une application complète de base de données relationnelle. Cette application permet de lister différents
concerts dans toute la Suisse avec la possibilité d’indiquer sa présence

## Comment run ce projet:
* Installez la denière version de [php](https://www.sitepoint.com/how-to-install-php-on-windows/) (N'oubliez pas de copier le fichier php.ini-development et de le renommer en php.ini)
* <a href="https://www.sitepoint.com/how-to-install-php-on-windows/" target="_blank">Hello, world!</a>
* Installez la dernière version de [postgres SQL](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)
* Installez [composer](https://getcomposer.org/)
* Modifiez le fichier config.php
* Dans le terminal: 
```js
cd D:\Concerino\src
composer dump-autoload // Il faut refaire ça dès qu'on crée un fichier/dossier
php -S localhost:8888 // ouvre un server local sur le port 8888
```
