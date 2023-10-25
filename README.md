# FLYFF_PROJECT

Ce projet est construit avec Symfony et nécessite certaines étapes pour être installé et exécuté correctement.


## Prérequis

Avant de commencer, assurez-vous que vous avez les éléments suivants installés sur votre système :

- PHP 8.1 ou supérieur
- Composer (https://getcomposer.org/)
- Un serveur web (par exemple, Apache ou Nginx)
- Une base de données compatible avec Doctrine (par exemple, MySQL, PostgreSQL)
- Symfony CLI


## Installation

1. Clonez ce référentiel sur votre machine :

- git clone https://github.com/votre-utilisateur/votre-projet.git


2. Accédez au répertoire de votre projet :

- cd flyff_project


3. Configurez les paramètres de votre base de données (Fichier .env Ligne 29) :

- DATABASE_URL=mysql://votre-utilisateur:votre-mot-de-passe@localhost/flyff_project


4. Installez les dépendances du projet en utilisant Composer :

- composer install


5. Démarrez le serveur de développement intégré de Symfony :

- symfony server:start


## Comptes test
## Deux comptes test ont été créés et mis à disposition pour les tests

## Admin
- id: admintest
- password: admintest

## User classique
- id: usertest
- password: usertest


## Votre projet Symfony est maintenant accessible à l'adresse http://localhost:8000 dans votre navigateur.
