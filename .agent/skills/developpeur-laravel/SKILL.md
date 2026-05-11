---
name: developpeur-laravel
description: Expert Laravel Full Stack Developer - Backend, Auth, Permissions, Database
---


# Skill : Développeur Laravel

## 🎯 Périmètre Global
**Mission** : Développer le backend Laravel complet (Models, Controllers, Services, Auth, Permissions, Migrations, Seeders) pour réaliser le projet PropertyHub.

### 🚫 Interdictions Spécifiques
1. Ne jamais écrire de SQL brut (utiliser Eloquent)
2. Ne jamais laisser de logique métier dans les Controllers
3. Ne jamais utiliser dd() ou var_dump() en production
4. Frontend = géré par design agent (ne pas toucher aux vues Blade complexes)

---

## 🛠️ Capacités (Savoir-Faire Technique)

### 1. `capacité-analyse-projet.md`
- **Rôle** : Analyser l'état du projet Laravel existant

### 2. `capacité-models-migrations.md`
- **Rôle** : Créer/modifier Models et Migrations

### 3. `capacité-controllers-services.md`
- **Rôle** : Créer Controllers et Services

### 4. `capacité-auth-permissions.md`
- **Rôle** : Implémenter AUTH avec Laravel UI et Spatie

### 5. `capacité-seeders.md`
- **Rôle** : Créer des Seeders pour les données de test

---

## ⚡ Actions (Capacités Atomiques)

### Action 0 : Analyser Projet
> **Description** : Analyse l'état du projet Laravel existant et détermine ce qui doit être développé.

- **📊 Détection d'État** :
  1. **Lire** : analyser-besoin/cahier-des-charges.md
  2. **Lire** : organisation-contenu/content-strategy.md
  3. **Vérifier** : Routes dans routes/web.php
  4. **Vérifier** : Models existants dans app/Models/
  5. **Vérifier** : Migrations dans database/migrations/
  6. **Vérifier** : Controllers existants

- **Retour** :
  - Liste des fonctionnalités manquantes
  - État des Models/Controllers/Services existants
  -Plan de développement recommandé

### Action A : Créer Model + Migration
> **Description** : Crée un nouveau Model Eloquent avec sa Migration.

- **Inputs** :
  - `$NOM_MODEL` (ex: Property, Appointment, Message)
  - `$CHAMPS` (array de champs)
  - `$RELATIONS` (relations Eloquent)

- **Implémentation** :
  1. `php artisan make:model $NOM_MODEL -m`
  2. Définir $fillable dans le Model
  3. Définir les relations
  4. Configurer la Migration

### Action B : Créer Controller + Service
> **Description** : Crée un Controller RESTful avec son Service.

- **Inputs** :
  - `$NOM_MODELE` (ex: Property)
  - `$METHODES` (index, show, create, store, edit, update, destroy)

- **Implémentation** :
  1. `php artisan make:controller $NOMController --resource`
  2. Créer Service dans app/Services/
  3. Injecter Service dans Controller
  4. Implémenter les méthodes avec appels Service

### Action C : Configurer Auth
> **Description** : Configure l'authentification avec Laravel UI.

- **Inputs** :
  - `$ROLES` (admin, agent, client)

- **Implémentation** :
  1. Installer Laravel UI : `composer require laravel/ui`
  2. Configurer routes auth dans routes/web.php
  3. Créer contrôleur Auth (Custom)
  4. Créer views login/register
  5. Implémenter rôles dans table users

### Action D : Configurer Permissions Spatie
> **Description** : Configure les permissions avec Spatie.

- **Inputs** :
  - `$PERMISSIONS` (create-property, edit-property, delete-property, etc.)
  - `$ROLES` (admin, agent, client)

- **Implémentation** :
  1. `composer require spatie/laravel-permission`
  2. Publier config : `php artisan vendor:publish`
  3. Créer migration permissions
  4. Définir permissions dans seeder
  5. Créer roles dans seeder
  6. Implémenter middleware dans routes

### Action E : Créer Seeder
> **Description** : Crée des données de test.

- **Inputs** :
  - `$MODELE` (User, Property, etc.)
  - `$DONNEES` (nombre d'enregistrements)

- **Implémentation** :
  1. `php artisan make:seeder $NOMSeeder`
  2. Implémenter run() avec factories
  3. Appeler dans DatabaseSeeder

### Action F : Développer Fonctionnalité Complète
> **Description** : Développe une fonctionnalité de A à Z (Model + Migration + Controller + Service + Routes).

- **Inputs** :
  - `$FONCTIONNALITE` (ex: Properties Management, Appointments, Messages)

- **Implémentation** :
  1. Créer Model + Migration (Action A)
  2. Créer Controller + Service (Action B)
  3. Configurer Routes
  4. Créer Seeder (Action E)
  5. Tester

---

## 📋 Working Directory

- **Projet** : `PropertyHub-PFE/PropertyHub/`
- **Models** : `app/Models/`
- **Controllers** : `app/Http/Controllers/`
- **Services** : `app/Services/`
- **Migrations** : `database/migrations/`
- **Seeders** : `database/seeders/`
- **Routes** : `routes/web.php`

## Point de Contrôle (Definition of Done)

- [ ] Model créé avec relations correctes
- [ ] Migration fonctionnelle
- [ ] Controller RESTful avec Service
- [ ] Routes enregistrées
- [ ] Seeder créé pour tests
- [ ] Code suit PSR-12
- [ ] Pas de SQL brut
- [ ] Authentification fonctionnelle (si requis)
- [ ] Permissions Spatie (si requis)