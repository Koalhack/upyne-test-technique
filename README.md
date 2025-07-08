# UPYNE-Test-Technique

## Contexte

> L’objectif est de développer une application simple comprenant **un formulaire** permettant **d’enregistrer des utilisateurs** dans une table **MySQL**.
> Le formulaire devra inclure les champs suivants :
>
> - Nom d’utilisateur
> - Mot de passe
> - E-mail
>
> La structure de la base de données doit être conçue pour permettre la **modification** et la **désactivation** des utilisateurs, même si ces fonctionnalités ne sont pas à implémenter dans le cadre de ce test.
>
> Le design du formulaire ne sera pas évalué : un formulaire HTML simple suffira.
>
> Merci d’utiliser exclusivement du code **PHP 8 natif**, _sans framework ni modules via Composer_.
>
> La structure du code devra respecter les standards actuels en matière **d’organisation**, de **sécurité** et de **bonnes pratiques**.

## Objectif

Après avoir pris connaissance du contexte, j'ai pu prendre en compte les différents objectifs et attentes du projet.

### Stack technique

> La stack technique _"imposé"_ est assez simple dans son utilisation et dans sa mise en place

- Base de données: **MySQL**
- Langage back-end: **PHP 8**
- Langage front-end: **simple** (HTML, CSS, JS)

### Base de données

> Mais certains points du test semblaient laisser l'idée à plusieurs interprétations, notamment la base de données, qui doit être adaptée pour la **modification** et la **désactivation** des utilisateurs.

#### Modification

Normalement une base de données **SQL** permet une **modification** d'un à plusieurs tableaux de manière simple via la requête **UPDATE**.

Mais je pense que la présence dans le contexte du test du terme _"modification des utilisateurs"_ peut indiquer deux possibilités:

1. La mise en place d'un **système d'historique des modifications**
2. La nécessité de **droit utilisateur** pour la **modfications** de compte qui ne nous appartient pas

> J'ai décidé de me porter sur la deuxième possibilité étant donné son utilisation plus courante que la première.

#### Désactivation

Le terme _"Désactivation"_ m'a fais assez vite comprendre qu'il ne s'agissait de la suppression des données, mais uniquement la mise en place d'un système de **désactivation de compte** ce qui m'a données l'idée à deux possibilités :

1. Un système classique de logique **TOR** (**tout ou rien**) pour définir si un compte est **activer** ou **désactiver**
2. Un système de **suspension** de **compte** pendant un **temps données**

> Au vu du test fourni, j'ai plutôt opté pour un système basique de désactivation du compte ayant une logique binaire et ayant un meilleur lien avec mon choix précédent sur la _"modfication"_.

### Code

La structure du code se doit de respecter les standards actuels en matière **d’organisation**, de **sécurité** et de **bonnes pratiques**.

#### Organisations

J'ai donc décidé d'organiser ce projet autour de l'architecture **MVC** (Model View Controller)

```text
/upyne-test-technique/
├── config/
│   └── database.php
├── controllers/
│   └── UserController.php
├── models/
│   └── User.php
├── views/
│   └── user_create.php
└── index.php
```

#### Sécurité

Dans le cadre de la sécurité, les points suivants seront mis en place.

- Protections contre les **injections SQL**:
- Échappement des caractères spéciaux des entrées utilisateurs
- Utilisation des méthodes `prepare()` et `execute()`.
- Hachage du mot de passe utilisateurs avant sauvegarde sur base de données
- Utilisation de l'algorithme `bcrypt`
- Envoi E-mail de sécurité pour valider l'existence du mail

## Structure Base de données

La base de données sera donc composée d'une table, utilisateurs (`users`) comprenant les champs suivants :

| Name        | Type          | Settings                      | Note                           |
|-------------|---------------|-------------------------------|--------------------------------|
| **id** | INTEGER | 🔑 PK, not null, unique, autoincrement | |
| **username** | VARCHAR(50) | not null, unique | |
| **email** | VARCHAR(320) | not null, unique | |
| **pass_hash** | CHAR(60) | not null, unique | |
| **role** | ENUM | not null, default: 'user' | `admin`, `user` |
| **active** | BOOLEAN | not null, default: 0 | |

> **INFOS**
>
> - Le champ `id` est recommandé afin de garantir que chaque ligne soit unique et identifiable.
> - Le champ `email` est limité à **320 charactères**, car il s'agit de la taille maximum que peut avoir un email.
> - Le champ `pass_hash` contiendra des hashs utilisant l'algorithme **bcrypt** qui crée des **Hashs (version, cost, salt, hash)** composé de **60 caractères**.
> - Le champ `role` utilise le type `enum` afin de limité le nombre de possibilités, mais en restant suffisamment flexible pour de futurs autres rôles (modérateur, ...).

## Développement
