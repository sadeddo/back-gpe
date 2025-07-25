# 🛠️ NavZen – Back-End (Symfony 7)

**NavZen – Back-End** est une **API REST sécurisée par JWT** développée avec **Symfony 7**, destinée à l’application mobile NavZen.
Elle gère l’authentification (invité/utilisateur), les rôles, et exposera prochainement des routes de géolocalisation intérieure.

> ⚙️ Cette version est prête pour le développement local, compatible avec **ngrok** pour les tests sur mobile.

---

## 🚀 Lancer le projet

### Prérequis

* PHP ≥ 8.2 (`pdo_mysql`, `openssl`, etc.)
* Composer
* MySQL 8 (ou MariaDB ≥ 10.6)
* Symfony CLI
* ngrok (exposition en HTTPS requise)

### Installation

```bash
# Cloner le dépôt
git clone https://github.com/votre-utilisateur/navzen-back.git
cd navzen-back

# Installer les dépendances
composer install

# Créer le fichier d'environnement
touch .env.local
```

### Configuration de `.env.local`

```ini
DATABASE_URL="mysql://root:@127.0.0.1:3306/navzen_db?serverVersion=8&charset=utf8mb4"

###> lexik/jwt-authentication-bundle ###
JWT_PASSPHRASE=navzen_secret
###< lexik/jwt-authentication-bundle ###
```

Créer la base de données :

```sql
CREATE DATABASE navzen_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Finaliser l’installation :

```bash
php bin/console doctrine:migrations:migrate
php bin/console lexik:jwt:generate-keypair
symfony server:start --port=8000
```

---

### Exposer l'API avec ngrok (**obligatoire pour mobile**)

```bash
ngrok http 8000
```

Copiez l'URL `https` dans le front :
`front/src/services/api.js`

```js
export const API = axios.create({
  baseURL: 'https://<votre-ngrok>.ngrok-free.app/api',
});
```

---

## 📦 Packages installés

### Symfony & Bundles principaux

```bash
composer require symfony/orm-pack
composer require symfony/security-bundle
composer require symfony/validator
composer require lexik/jwt-authentication-bundle
composer require nelmio/cors-bundle
composer require doctrine/doctrine-fixtures-bundle --dev
```

---

## 📁 Structure du projet

```
/config                ← Sécurité, JWT, CORS
/src
  /Controller          ← AuthController.php, etc.
  /Entity              ← User.php, Location.php, etc.
  /DataFixtures        ← Données de test
/migrations            ← Fichiers SQL
/public                ← index.php (front-controller)
```

---

## 🧪 État actuel

* ✅ Authentification via JWT (**/register**, **/login**, **/guest**)
* ✅ Gestion des rôles : `USER`, `GUEST`
* ✅ Configuration CORS compatible Expo
* ⏳ Endpoints POIs, routes et notifications à venir

---

## 🐳 Commandes utiles

```bash
# Générer une migration
php bin/console make:migration

# Charger les fixtures
php bin/console doctrine:fixtures:load --append

# Forcer la mise à jour du schéma
php bin/console doctrine:schema:update --force
```

---