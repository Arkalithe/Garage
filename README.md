
## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre système :

- [Node.js](https://nodejs.org) (version 16.17.1)
- [PHP](https://php.net) (version 8.1.10)
- [MySQL](https://mysql.com) (version 10.4.24-MariaDB) 
- [Git](https://git-scm.com) (version 2.4.1.0windows.1)

## Instructions
Si vous voulez accedez a la version a ligne :
Front : `https://imaginative-lollipop-cdaa75.netlify.app/`
Back : `https://garagevparrotstudi-15b74863d868.herokuapp.com/`

Suivez ces étapes pour exécuter le projet en local :

1. Clonez le dépot en utilisant la commande suivante :

git clone -b alternate-api https://github.com/Arkalithe/Garage

On vous pouvez allez sur ce lien`https://github.com/Arkalithe/Garage` choisire la branche `alternate-api` cliquer sur le bouton `Code`
Puis  `Download ZIP`

2. Accédez au répertoire du projet :

cd Garage

3. Installez les dépendances nécessaires pour le front-end (React) :

npm install

composer install

## Back-End Setup

4. Avant d'exécuter l'application, assurez-vous de configurer les paramètres de connexion à la base de données. 

Ouvrez le fichier `Connect.php` situé dans le répertoire back-end`(php/Database/Connect.php)` et mettez à jour les variables suivantes 

### Database Configuration

```php
$serverName = "localhost"; 
$userName = "root";
$password = "";
$dbName = "garagevparrot";
```
5. Adaptez les valeurs des variables en fonction de votre configuration spécifique de la base de données. 

`serverName` doit être défini sur le nom d'hôte ou l'adresse IP de votre serveur de base de données, 

`userName` et password doivent correspondre aux identifiants de votre utilisateur MySQL,  

`dbName` doit être le nom de la base de données que vous souhaitez utiliser.

Enregistrez les modifications.

6. Ouvrez le fichier `CreationDb.php` situé dans le répertoire back-end`(php/Database/CreationDb.php` et mettez à jour le nom de base de donnée si vous l'avez changer

7. Lancer Mysql soit avec la commande :

windows = mysqld,

macOs = sudo /usr/local/mysql/bin/mysqld_safe,

Linux = sudo service mysql start,

Ou si vous utilisez un package comme XMAPP utilisez l'interface correspondant.

Vérifier que vous avez bien accès à la base de données.

8. Démarrez le serveur de développement back-end:

php -S localhost:8000

Ou si vous utilisez un package comme XMAPP utilisez l'interface correspondant.

9. Connecter vous sur http://localhost/Garage/php/Database/InitDb.php Cela vous permetra Lancez le fichier `InitDb.php`et  cela va créer les différentes tables et ajouter des données à l'intérieur. 

10. Une fois la base de donnée crée vous vous pouvez crée votre compte administateure sur `http://localhost/Garage/php/Index.php`.

11. Démarrez le serveur de développement front-end:
npm start

11. Ouvrez votre navigateur et accédez à l'URL suivante : `http://localhost:3000`, où `3000` est le port utilisé par l'application.



