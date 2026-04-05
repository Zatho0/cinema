# 🎬 CINEMA - Application Web de Vente de Films

**Cinema** est une plateforme e-commerce moderne permettant de parcourir un catalogue de films, de gérer un panier d'achat et de consulter son historique de commandes. L'application utilise l'API **TMDB** (The Movie Database) pour alimenter son catalogue avec des données réelles.

---

## 📝 Présentation du Projet

Cette application a été développée avec le framework **Laravel 13**. Elle offre une expérience utilisateur complète allant de l'authentification à la gestion du profil, en passant par un système de filtrage dynamique des films par catégorie ou réalisateur.

### Fonctionnalités principales
*   **Authentification complète** : Inscription, connexion, et gestion du profil (via Laravel Breeze).
*   **Catalogue dynamique** : Affichage "Hero", recherche par titre et filtres par catégories.
*   **Gestion du panier** : Ajout, suppression et vidage du panier en temps réel.
*   **Historique d'achats** : Suivi des films acquis par l'utilisateur.
*   **Seeding API** : Importation automatique de films depuis l'API TMDB.

---

## 🛠 Stack Technique

*   **Framework :** Laravel 13 (PHP 8.3)
*   **Frontend :** Blade, Tailwind CSS & Alpine.js
*   **Build Tool :** Vite 8.0
*   **Base de données :** MySQL / SQLite
*   **Tests :** Pest PHP

---

## 📂 Documentation Technique (Architecture)

Le projet respecte l'architecture **MVC** (Modèle-Vue-Contrôleur) de Laravel :

*   **Modèles (`app/Models/`)** : `User`, `Movie`, `Cart`, `Categories`, `Purchase`.
*   **Contrôleurs (`app/Http/Controllers/`)** :
    *   `MovieController` : Gestion du catalogue et des détails de films.
    *   `CartController` : Logique du panier (ajout, suppression).
    *   `ProfileController` : Gestion du compte et historique.
*   **Vues (`resources/views/`)** : Templates Blade organisés par composants réutilisables.
*   **Routes (`routes/web.php`)** : Définition des accès publics et protégés (middleware `auth`).

---

## 🗄 Schéma de Base de Données

Le projet s'appuie sur **7 tables** principales gérées par les migrations Laravel.

### 🧬 Relations Clés
*   **Categories (1:N) Movie** : Une catégorie contient plusieurs films.
*   **User (1:N) Cart** : Un utilisateur possède un panier unique d'articles.
*   **User (1:N) Purchase** : Un utilisateur peut effectuer plusieurs achats.

> **Note :** Le générateur de schéma se trouve dans `database/migrations/`.

---

## 🚀 Installation et Configuration

### 1. Prérequis
*   PHP >= 8.3
*   Composer & Node.js (NPM)
*   Une clé API TMDB (Optionnel, pour le seeder)

### 2. Procédure d'installation rapide
Le projet utilise un script automatisé pour simplifier l'installation :

```bash
# Cloner le projet
git clone [https://github.com/Zatho0/cinema.git](https://github.com/Zatho0/cinema.git)
cd cinema

# Lancer l'installation automatique
composer run setup