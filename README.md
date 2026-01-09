# PHP Framework

Guide pour suivre étape par étape la création d'un framework simple en PHP.

Ce framework se base sur le modèle MVC et s'inspire de ce que peuvent faire Symfony et Laravel. Il sera composé d'un routeur, d'un ORM et d'un moteur de template simple.

On pourra utiliser ce framework pour créer des API ou des applications monolithes.

## Sommaire

<!--toc:start-->
- [PHP Framework](#php-framework)
  - [Sommaire](#sommaire)
  - [Étape 0](#étape-0)
  - [Étape 1](#étape-1)
  - [Étape 2](#étape-2)
  - [Étape 3](#étape-3)
  - [Étape 4](#étape-4)
  - [Étape 5](#étape-5)
  - [Étape 6](#étape-6)
  - [Étape 7](#étape-7)
<!--toc:end-->

## Étape 0

**Objectif** : initialiser le projet

- créer un fichier `docker-compose.yml` et un fichier `Dockerfile` avec les configurations nécessaires pour développer une application en PHP
- ajouter un fichier `app/index.php` pour pouvoir tester si le conteneur est valide

## Étape 1

**Objectif** : rediriger toutes les requêtes vers `app/src/index.php`

- pour pouvoir préparer le routeur, on a besoin de rediriger toutes les requêtes vers une entrée unique
- créer un dossier `app/src` : il contiendra l'intégralité du code PHP du framework
- y déplacer le fichier `index.php`
- créer un fichier `app/.htaccess` pour y écrire les règles de redirection

## Étape 2

**Objectif** : récupérer les informations de la requête pour qu'on puisse la traiter

- modifier le fichier `app/src/index.php` avec les fonctions nécessaires 

## Étape 3

**Objectif** : extraire le code précédent dans une classe

- créer un dossier `app/src/Http` : il contiendra toutes les fonctionnalités du framework liées aux requêtes HTTP
- y ajouter un fichier `app/src/Http/Request.php` avec le code d'`index.php`
- lancer la commande `composer init` pour pouvoir utiliser l'`autoload.php` de composer et charger dynamiquement les classes

## Étape 4

**Objectif** : préparer le routeur

- créer un dossier `app/config` : il contiendra tous les fichiers de configuration nécessaires au fonctionnement du framework
- y ajouter un fichier `app/config/routes.json` : on y enregistrera les configurations de nos endpoints
- modifier le fichier `app/src/index.php` pour accorder l'accès ou non aux endpoints en fonction du fichier `app/config/routes.json`

## Étape 5

**Objectif** : compléter le routeur avec une classe dédiée

- créer un fichier `app/src/Http/Router.php`
- y déplacer le code de `app/src/index.php`

## Étape 6

**Objectif** : exécuter un controller en fonction de l'endpoint

- créer un dossier `app/src/Controllers` : on y stockera les controllers
- créer un fichier `app/src/Controllers/AbstractController.php` : il servira de modèle à tous les futurs controllers
- adapter `app/src/Http/Router.php` pour qu'il instancie une classe controller et l'exécute

## Étape 7

**Objectif** : renvoyer une objet Response

- créer un fichier `app/src/Http/Response.php` avec la configuration pour une réponse HTTP
- faire en sorte que les controllers et le routeur retournent une instance de `Response.php`
