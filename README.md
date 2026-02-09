# R6.A.05 Développement Avancé: Projet Plateforme cours

Plateforme utilisant différentes technologies:

- Backend
  - Twig (Template pages)
  - Bootstrap (Interface [CSS + JS])
  - Symfony 8.0 (Framework [PHP])
    - SecurityBundle (Système d'authentification)
    - Doctrine (ORM)
  - API Platform (Accès API)
  - API Mistral (IA)
- BDD
  - MySQL en local avec le moteur InnoDB
- Frontend
  - React (Framework [JavaScript])
  - TailwindCSS (CSS)
  - Axios pour consommer API

# Configuration initiale
> :warning: **Information importante :** L'environnement testé et recommandé est **Linux Ubuntu 22**.

## Configuration de l'environnement dans le fichier `backend/.env`
- Dans le `backend`, créer le fichier `.env` sur le modèle du fichier `.env.example`.
- Ajouter la **clef de l'API de l'IA de Mistral** [Voir comment ajouter la clef Mistral](#clef-api-mistral).
- Ajouter la connexion à la **base de données MySQL en local** [Voir comment créer la base de données MySQL](#base-de-données-mysql).

## Clef API Mistral
Créer un compte sur le site de [Mistral](https://mistral.ai/) et créer un compte. Une fois cela, dans le menu **Mistral AI Studio**,
créez une clef API et dans le fichier `backend/.env`, écrire la ligne suivante :
`MISTRAL_AI_API=key_API` avec *key_API* la clef que vous avez générée.

## Base de données MySQL
Pour créer la base de données MySQL en local, il faut d'abord l'installer : `sudo apt install mysql`.<br>
Par la suite, saisissez dans le terminal `sudo mysql` et entrer votre mot de passe sudo.
Vous devez ensuite créer une nouvelle base de données avec `CREATE DATABASE nom_bd;`<br>
Saisissez les commandes pour générer un utilisateur :
```mysql
USE mysql;
CREATE USER 'username'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
SELECT Host,User FROM user\G; # Vérifier que l'utilisateur a bien été ajouté
exit;
```
Une fois sortit de MySQL, si vous saisissez `mysql -uusername -ppassword` et que vous vous connectez
à MySQL avec la base de données, c'est que la création de l'utilisateur à fonctionner. 

Enfin, dans le fichier `backend/.env`, écrire la ligne suivante :
`DATABASE_URL="mysql://username:password@127.0.0.1:3306/nom_db?serverVersion=8.0.44&charset=utf8mb4"`
avec `username` le nom d'utilisateur, `password` le mot de passe et `nom_db` le nom de la base de données.

# Fixtures
Dans le dossier `backend/src/DataFixtures`, vous pouvez générer un échantillon de données
pour remplir la base de données. Pour ce faire, dans `backend/`, il suffit de saisir la commande `symfony console doctrine:fixtures:load`.

# API du backend
Vous pouvez accéder à l'API de la plateforme en saisissant le lien (http://127.0.0.1:8000/api) dans un navigateur Web.

> Rizzante--Madonna Alexandre, 3ème année BUT Informatique Groupe A1
