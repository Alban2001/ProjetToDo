# PROJET 8 : Améliorez une application existante de ToDo & Co

**Date de création** : 19 août 2024
**Date de la dernière modification** : 19 août 2024
**Auteur** : Alban VOIRIOT
**Informations techniques** :

- **Technologies** : HTML, CSS, PHP, Symfony, SQL, JavaScript, Bootstrap, MySQL
- **Version de Symfony** : 6.4.6
- **Version de PHP** : 8.3.7
- **Version de MySQL** : 5.7.11
- **Version de Bootstrap** : 5.0.2

## Sommaire

- [Contexte](#contexte)
- [Installation](#installation)
  - [Télécharger le projet](#télécharger-le-projet)
  - [Configurer la base de données](#configurer-la-base-de-données)
- [Guide d'utilisation](#guide-dutilisation)
  - [Compte utilisateur](#compte-utilisateur)
  - [Compte administrateur](#compte-administrateur)

## Contexte

Ce projet a été conçu dans le cadre de ma formation de développeur d'applications PHP/Symfony (OpenClassrooms) afin d'améliorer l'application ToDo & Co en implémentant de nouvelles fonctionnalités, correction de certaines anomalies puis l'implémentation de tests automatisés.

## Installation

### Télécharger le projet

=> Pour télécharger le dossier, veuillez effectuer la commande GIT : `git clone https://github.com/Alban2001/ProjetToDo.git`

=> Dans le terminal de Symfony, effectuer les commandes : `cd ProjetToDo ` puis `composer install` afin de pouvoir installer les fichiers manquants de composer et mettre à jour. Un message d'erreur va apparaître, car dans le fichier .env, il manque la variable **_DATABASE_URL_** qui n'est pas à jour.

### Configurer la base de données

- => Remplissez la variable **_DATABASE_URL_** dans le fichier .env et .env.test afin de permettre au projet de communiquer avec la base de données.

  Exemple :

```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

Afin d'ajouter la base de données du projet dans votre SGBDR, veuillez simplement lancer les commandes dans le terminal de Symfony : `php bin/console make:migration` puis `php bin/console doctrine:migrations:migrate`.

Pour les tests, lancez les commandes `php bin/console --env=test doctrine:database:create` puis `php bin/console --env=test doctrine:schema:create`

- Afin d'ajouter des insertions automatiques de 5 tâches et 2 utilisateurs (1 user + 1 admin), lancez la commande : `php bin/console doctrine:fixtures:load` (pour les tests: `php bin/console --env=test doctrine:fixtures:load` afin de remplir aussi la base de données de test) pour avoir une base sur le site.

## Guide d'utilisation

En arrivant sur le site en simple visiteur, vous aurez juste les accès à la page d'accueil.

### Compte utilisateur

Si vous souhaitez créer une nouvelle tâche ou consulter la liste des tâches à faire.
Veuillez vous connecter avec l'utilisateur suivant :

- Mail : alban.voiriot@gmail.com
- Mot de passe : Alban93498?!

### Compte administrateur

Si vous souhaitez créer un nouvel utilisateur ou consulter la liste des utilisateurs.
Veuillez vous connecter avec le compte administrateur suivant :

- Mail : admin@mail.fr
- Mot de passe : Admin93498?!
