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

> - Envoi Email de sécurité pour valider l'existence du mail
>
> Cette fonctionnalité serait plus facile à mettre en place avec un module comme **PHPMailer**

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
| **created_at** | TIMESTAMP | not null, default: CURRENT_TIMESTAMP | |
| **updated_at** | TIMESTAMP | not null, default: CURRENT_TIMESTAMP, on update: CURRENT_TIMESTAMP | |

> **INFOS**
>
> - Le champ `id` est recommandé afin de garantir que chaque ligne soit unique et identifiable.
> - Le champ `email` est limité à **320 charactères**, car il s'agit de la taille maximum que peut avoir un email.
> - Le champ `pass_hash` contiendra des hashs utilisant l'algorithme **bcrypt** qui crée des **Hashs (version, cost, salt, hash)** composé de **60 caractères**.
> - Le champ `role` utilise le type `enum` afin de limité le nombre de possibilités, mais en restant suffisamment flexible pour de futurs autres rôles (modérateur, ...).

## Développement

### Gestion de la base de données

Une fois, le développement lancé, la première chose que je devais faire était configurer la base de données, pour cela, je savais que j'allais utiliser **Docker** et **Docker Compose** afin de facilement gérer la configuration et création de la base de données via les variables d'environnement.

Mais il restait un autre point à élucider, comment gérer la création et possible modification de la table.
Dans ce genre de cas, je ne connais que deux méthodes :

1. Le faire manuellement via de simple requête **SQL**
2. Utiliser un outil **ORM** qui s'en charge pour moi

Après recherche, il était aussi possible d'initialiser la base de données avec des fichiers `.sql` custom via `docker-entrypoint-initdb.d`

```yaml
volumes:
- ./init.sql:/docker-entrypoint-initdb.d/init.sql
```

La limite dans ma deadline et mes contraintes a uniquement utiliser PHP 8, je me suis donc tourné vers la solution de **Docker** ainsi que la mise en place d'une image **phpmyadmin** pour des modifications manuel si nécessaire.

### Ajout d'utilisateurs

À cette étape, j'ai pu réaliser l'ajout d'utilisateur de manière _"théorique"_, en utilisant l'utilitaire **PHP**.

```bash
php app/controllers/UserController.php
```

J'ai géré les erreurs suivantes :

```stderr
Deprecated: PHP Startup: session.sid_length INI setting is deprecated in Unknown on line 0
PHP Deprecated:  PHP Startup: session.sid_bits_per_character INI setting is deprecated in Unknown on line 0
```

Après quelques recherches, j'avais trouvé la [solution](https://suay.site/?p=4994)

Il suffit de modifier le fichier `php.ini` en commentant les lignes

```ini
;session.sid_length =
;session.sid_bits_per_character =
```

> J'ai profité de l'occasion pour activer l'extension `pdo_mysql`
>
> ```
> extension=pdo_mysql
> ```

La suite n'aura pas causé de problème particulier durant le développement.

J'ai principalement eu des problèmes via le système d'_"autoload"_ de `composer` qui m'aura causé quelques ennuis jusqu'au moment ou je me suis souvenu qu'il fallait charger le fichier `autoload.php`:

```php
require __DIR__ . '/vendor/autoload.php';
```

Je n'avais jamais eu à le faire avec **Laravel** ou **Symfony**.

>```bash
>composer dump-autoload
>```

Avec ces quelques modifications, j'ai modifié la structure du projet (tout en gardant l'architecture **MVC**).

```text
/upyne-test-technique/
├── config/
│   └── database.php
├── app/
│   ├── core/
│   ├── controllers/
│   └── models/
└── index.php
```

### Validation des données et messages d'erreurs

Cette partie n'aura pas été particulièrement compliquée.
J'ai créé une classe `Validator` afin que toutes les vérifications des différentes entrées utilisateur et la gestion des messages d'erreurs du formulaire utilisateur puisse être au même endroit plutôt que disperser dans le code et mal organisé.

### Création de l'interface utilisateur

Pour la partie de l'interface utilisateur, pour cela, j'ai d'abord réalisé un formulaire **HTML/CSS** très simple afin de me concentré sur le **PHP**.

Après cela, j'ai utilisé **ChatGPT** afin qu'il me génère un formulaire, utilisateurs ayant une meilleure apparence, il ne restait que quelques modifciations à faire pour correctement fonctionner avec le système et le problème était résolue.

### Vérification de l'existence d'un utilisateur

Pour cette section rien de bien compliquer, j'ai créé une classe étendue `UserValidtor` de la classe `Validator` afin d'ajouter la gestion des potentiels compte `username` ou `email` qui existerais déjà.

## Utilisation

Pour mettre en place ce petit projet rapidement par sois même, le plus rapide est d'utiliser **Docker**:

1. Cloner le dépôt Github

```bash
git clone https://github.com/Koalhack/upyne-test-technique.git
```

2. Lancer la commande `docker compose` suivante :

```bash
docker-compose --env-file .env.example up --build -d
```

> **Attention**
>
> Ce test était à réaliser sans aucun framework ou module, j'ai donc été contraint de stocker les informations de connexion de la base de données dans le fichier `config/database.php`.
> Si vous modifiez le fichier de variables d'environnement, il faudra aussi modifier les valeurs de ce fichier.

## Roadmap

- [ ] Ajouter commentaires et PHPdoc
- [ ] Mettre en place un système de _"routes"_
- [ ] Améliorer la sécurité (email, `.htaccess`)
