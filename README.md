# 🎬 CINEMA - Application Web de Vente de Films

**Cinema** est une plateforme e-commerce moderne permettant de parcourir un catalogue de films alimenté par l'API **TMDB**, de gérer un panier d'achat et de consulter un historique de commandes. Développé avec **Laravel 13**, ce projet met l'accent sur une architecture propre et une expérience utilisateur fluide.

---

## 1. Présentation du Projet

L'application permet aux utilisateurs de s'inscrire, de naviguer dans un catalogue organisé par catégories (Action, Drame, etc.), d'effectuer des recherches par titre ou réalisateur, et de finaliser des achats virtuels.

### Fonctionnalités principales :
*   **Authentification complète** : Inscription, connexion, et gestion du profil via Laravel Breeze.
*   **Catalogue dynamique** : Affichage d'un film "Hero" aléatoire et recherche en temps réel.
*   **Système de Panier** : Ajout/suppression d'articles avec calcul automatique du total.
*   **Historique d'achats** : Suivi des films acquis dans l'espace profil.
*   **Importation API** : Peuplement de la base de données via l'API *The Movie Database*.

---

## 2. Stack Technique

*   **Backend** : Laravel 13 (PHP 8.3)
*   **Frontend** : Blade Templates, Tailwind CSS & Alpine.js
*   **Build Tool** : Vite 8.0
*   **Base de données** : MySQL / SQLite
*   **Client HTTP** : Guzzle (pour les appels API TMDB)
*   **Tests** : Pest PHP

---

## 3. Architecture & Documentation Technique

Le projet suit l'architecture **MVC** (Modèle-Vue-Contrôleur) de Laravel.

### 📁 Structure des répertoires clés
| Répertoire | Rôle |
| :--- | :--- |
| `app/Models/` | Entités Eloquent (`User`, `Movie`, `Cart`, `Categories`, `Purchase`) |
| `app/Http/Controllers/` | Logique métier (`MovieController`, `CartController`, `ProfileController`) |
| `database/migrations/` | **Générateur de schéma de base de données** |
| `database/seeders/` | Scripts de peuplement (dont le `MovieSeeder` pour TMDB) |
| `resources/views/` | Interfaces utilisateur (Templates Blade) |
| `routes/web.php` | Déclaration des routes et endpoints de l'application |

### ⚙️ Flux de la requête
1. La requête arrive sur `public/index.php`.
2. Le routeur identifie le contrôleur (ex: `MovieController@index`).
3. Le contrôleur récupère les données via les Modèles (Eager loading pour optimiser le SQL).
4. Les données sont envoyées à la vue Blade pour rendu HTML.

---

## 4. Base de Données (Schéma)

L'application s'appuie sur **7 tables** principales. Les relations sont gérées par des clés étrangères avec suppression en cascade pour l'intégrité des données.

### Diagramme de relations (Résumé) :
*   **Categories (1:N) Movie** : Une catégorie possède plusieurs films.
*   **User (1:N) Cart** : Un utilisateur possède plusieurs articles temporaires.
*   **User (1:N) Purchase** : Un utilisateur possède un historique d'achats définitifs.
*   **Movie (1:N) Cart/Purchase** : Un film peut être présent dans plusieurs paniers ou achats.

---

## 5. Procédure d'Installation

### 📋 Prérequis
*   PHP >= 8.3
*   Composer & Node.js (NPM)
*   Une clé API TMDB (optionnel pour le seeder)

### 🚀 Installation rapide
Le projet inclut une commande automatisée pour configurer l'environnement :

```bash
# 1. Clonage du dépôt
git clone [https://github.com/Zatho0/cinema.git](https://github.com/Zatho0/cinema.git)
cd cinema

# 2. Installation automatique (Dépendances PHP/JS, Clé, Migrations)
composer run setup

```
Gemini a dit
C'est exact, ces instructions sont cruciales pour que le correcteur puisse faire fonctionner ton projet immédiatement après l'avoir téléchargé.

Voici le fichier README.md complet et définitif, incluant toutes les sections précédentes ainsi que la configuration API, le peuplement (seeding) et le lancement du serveur.

Markdown
# 🎬 CINEMA - Application Web de Vente de Films

**Cinema** est une plateforme e-commerce moderne permettant de parcourir un catalogue de films alimenté par l'API **TMDB**, de gérer un panier d'achat et de consulter un historique de commandes. Développé avec **Laravel 13**, ce projet met l'accent sur une architecture propre et une expérience utilisateur fluide.

---

## 1. Présentation du Projet

L'application permet aux utilisateurs de s'inscrire, de naviguer dans un catalogue organisé par catégories (Action, Drame, etc.), d'effectuer des recherches par titre ou réalisateur, et de finaliser des achats virtuels.

### Fonctionnalités principales :
*   **Authentification complète** : Inscription, connexion, et gestion du profil via Laravel Breeze.
*   **Catalogue dynamique** : Affichage d'un film "Hero" aléatoire et recherche en temps réel.
*   **Système de Panier** : Ajout/suppression d'articles avec calcul automatique du total.
*   **Historique d'achats** : Suivi des films acquis dans l'espace profil.
*   **Importation API** : Peuplement de la base de données via l'API *The Movie Database*.

---

## 2. Stack Technique

*   **Backend** : Laravel 13 (PHP 8.3)
*   **Frontend** : Blade Templates, Tailwind CSS & Alpine.js
*   **Build Tool** : Vite 8.0
*   **Base de données** : MySQL / SQLite
*   **Client HTTP** : Guzzle (pour les appels API TMDB)

---

## 3. Architecture & Documentation Technique

Le projet suit l'architecture **MVC** (Modèle-Vue-Contrôleur) de Laravel.

### 📁 Structure des répertoires clés
| Répertoire | Rôle |
| :--- | :--- |
| `app/Models/` | Entités Eloquent (`User`, `Movie`, `Cart`, `Categories`, `Purchase`) |
| `app/Http/Controllers/` | Logique métier (`MovieController`, `CartController`, `ProfileController`) |
| `database/migrations/` | **Générateur de schéma de base de données** |
| `database/seeders/` | Scripts de peuplement (dont le `MovieSeeder` pour TMDB) |
| `resources/views/` | Interfaces utilisateur (Templates Blade) |
| `routes/web.php` | Déclaration des routes et endpoints de l'application |

---

## 4. Base de Données (Schéma)

L'application s'appuie sur **7 tables** principales. Les relations sont gérées par des clés étrangères avec suppression en cascade.

### 🧬 Relations Clés
*   **Categories (1:N) Movie** : Une catégorie possède plusieurs films.
*   **User (1:N) Cart** : Un utilisateur possède plusieurs articles temporaires.
*   **User (1:N) Purchase** : Un utilisateur possède un historique d'achats définitifs.

---

## 5. Procédure d'Installation

### 📋 Prérequis
*   PHP >= 8.3
*   Composer & Node.js (NPM)
*   Une clé API TMDB (gratuite sur themoviedb.org)

### 🚀 Installation rapide
Le projet inclut une commande automatisée pour configurer l'environnement :

```bash
# 1. Clonage du dépôt
git clone [https://github.com/Zatho0/cinema.git](https://github.com/Zatho0/cinema.git)
cd cinema

# 2. Installation automatique (Dépendances PHP/JS, Clé, Migrations)
composer run setup
🔑 Configuration API
Ajoutez votre clé TMDB dans le fichier .env pour activer l'importation automatique des films :

Extrait de code
TMDB_API_KEY=votre_cle_api_ici
🎲 Peuplement des données (Seeding)
Pour générer l'utilisateur de test et importer les films réels via l'API :

Bash
# Créer l'utilisateur test (test@example.com) et les catégories
php artisan db:seed

# Importer les films Marvel depuis l'API TMDB
php artisan db:seed --class=MovieSeeder
💻 Lancement du serveur
Pour démarrer simultanément le serveur PHP et la compilation des assets (Vite) :

Bash
composer run dev