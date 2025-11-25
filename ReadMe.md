
# Bibliothèque – Projet Symfony

Ce projet est une application web de gestion de bibliothèque développée en **Symfony**.
Il permet la gestion des ouvrages, exemplaires, emprunts, réservations et utilisateurs, avec une gestion des rôles (Admin / Librarian / Member).

---

## 1. Prérequis

Assurez-vous d’avoir installé :

* **PHP 8.1+**
* **Composer**
* **Symfony CLI**
  Installation : [https://symfony.com/download](https://symfony.com/download)
* **PostgreSQL**
* **Git**
* **Node.js + npm** (si vous utilisez Webpack Encore)

---

## 2. Installation du projet

### **Cloner le dépôt**

```bash
git clone https://github.com/SPUPHF/bibliotheque.git
cd bibliotheque
```

### **Installer les dépendances PHP**

```bash
composer install
```

---

## 3. Configuration de la base de données

### Modifier le fichier `.env` :

```
DATABASE_URL="postgresql://postgres:password@127.0.0.1:5432/bibliotheque?serverVersion=15&charset=utf8"
```

Adapter :

* **postgres** = identifiant PostgreSQL
* **password** = mot de passe PostgreSQL
* **bibliotheque** = nom de la base

### Créer la base de données :

```bash
php bin/console doctrine:database:create
```

### Exécuter les migrations :

```bash
php bin/console doctrine:migrations:migrate
```

### Charger les fixtures (pour créer admin, ouvrages, etc.) :

```bash
php bin/console doctrine:fixtures:load
```

---

## 4. Comptes utilisateur par défaut

Fixtures installent notamment :

### **Admin**

* **Email** : [admin@example.com](mailto:admin@admin.com)
* **Mot de passe** : admin123
### ***AUCUN MIS A PART L'ADMIN NE FONCTIONNE, APRES PLUSIEURS HEURES A CHERCHER LE PROBLEME, JE NE SUIS PAS PARVENUE A LE RESOUDRE***
### **Librarian**

* **Email** : [biblio@example.com](mailto:librarian@test.com)
* **Mot de passe** : motdepasse123

### **Member**

* **Email** : [membre@example.com](mailto:member@test.com)
* **Mot de passe** : motdepasse123

---

## 5. Lancer l’application

```bash
symfony server:start
```

Naviguer ensuite sur :

👉 [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

---

## 6. Structure rapide du projet

```
src/
 ├─ Controller/       → Contrôleurs MVC
 ├─ Entity/           → Entités Doctrine
 ├─ Repository/       → Accès BD
templates/            → Templates Twig
public/               → Fichiers publics (CSS/JS)
```

---

## 7. Gestion des rôles

| Rôle          | Accès                                                            |
| ------------- | ---------------------------------------------------------------- |
| **Admin**     | Gestion complète + panneau admin                                 |
| **Librarian** | Gérer ouvrages, exemplaires, emprunts, réservations              |
| **Member**    | Voir uniquement *ses propres* emprunts / réservations + ouvrages |




