# SSPR-POC

Self-Service Password Reset
Changement et réinitialisation de mot de passe

## Pour commencer

C'est une application Web

### Pré-requis

- HTTPS
- PHP > 7.2
- Sendmail / Postfix

### Installation

Créer un fichier .env à la racine

```properties
APP_ENV=development
APP_DIR=/chemin/vers/projet/depuis/racine/apache
APP_URL=https://url/a/envoyer/par/courriel/avec/le/token/de/recuperation

BM_HOST=https://url.api.webmail
BM_LOGIN=login
BM_PASSWORD=password_ou_token
```

Créer un fichier vide app.log à la racine

Créer un fichier user.csv

```csv
nom.prenom@inserm.fr;email@secours.fr;;
nom.prenom@inserm.fr;email@secours.fr;;
nom.prenom@inserm.fr;email@secours.fr;;
nom.prenom@inserm.fr;email@secours.fr;;
nom.prenom@inserm.fr;email@secours.fr;;
```

## Démarrage

### Avec un serveur web

Configurer le module de réécrire d'url sur votre serveur web ou alors créer un fichier .htaccess à la racine

```apache
<IfModule mod_rewrite.c>
    RewriteEngine on

    RewriteCond %{REQUEST_URI} !^.*\.(css|js|png|jpg|gif|ico)$ [NC]
    RewriteRule ^(.*)$ public/index.php [QSA,L]

    RewriteCond %{REQUEST_URI} ^.*\.(css|js|png|jpg|gif|ico)$ [NC]
    RewriteRule ^(css|js|img)/(.*)$ public/$1/$2 [NC,L]
</IfModule>
```

### Avec le serveur web interne de PHP

Placer vous à la racine du projet et lancer la commande pour simuler la réécrire d'url

```shell
php -S localhost:80 public/redirect.php
```

## Fabriqué avec

- [Visual Studio Code](https://code.visualstudio.com/) - Editeur de textes

## Contributing

Si vous souhaitez contribuer, lisez le fichier [CONTRIBUTING.md](http://sourcesup.renater.fr/www/sspr-poc/CONTRIBUTING.md) pour savoir comment le faire.

## Versions

- **Dernière version stable :** 0.0.0
- **Dernière version :** 0.0.0

Liste des versions : [Cliquer pour afficher](http://sourcesup.renater.fr/www/sspr-poc/tags)

## Auteurs

**Salim YDJEDD** _alias_ [@sydjedd](http://sourcesup.renater.fr/www/)

Liste des contributeurs : [Cliquer pour afficher](http://sourcesup.renater.fr/www/sspr-poc)

## License
