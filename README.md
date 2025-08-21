# 🛒 Catalogue Produits & Panier (Test Symfony)

Application Symfony permettant de gérer un catalogue de produits avec un panier stocké en session.  
Fonctionnalités principales :
- Liste des produits
- Page détail produit avec ajout au panier
- Panier stocké en session (ajout, suppression, mise à jour, vider)
- Backoffice avec EasyAdmin
- Slug automatique pour les produits
- Fixtures pour peupler la base (12 produits)
- Tests unitaires et fonctionnels
- Docker & Makefile pour une installation rapide
- Front en Bootstrap via Webpack Encore
- API (API Platform) exposant les produits en JSON
- Export CSV de tous les produits via une commande console

---

## 📑 Sommaire
- [⚙️ Installation](#️-installation)
- [🗄️ Base de données & Fixtures](#️-base-de-données--fixtures)
- [🎨 Compilation des assets](#-compilation-des-assets)
- [🚀 Lancer le projet](#-lancer-le-projet)
- [🧪 Lancer les tests](#-lancer-les-tests)
- [🔑 Accès à l’administration](#-accès-à-ladministration)
- [🌐 API (produits en JSON)](#-api-produits-en-json)
- [📊 Export CSV des produits](#-export-csv-des-produits)
- [📂 Structure du projet](#-structure-du-projet)

---

## ⚙️ Installation

Cloner le projet et se placer dans le dossier :

```
git clone https://github.com/Isaacaal/shop.git
cd shop
```

Lancer l’installation (Docker + dépendances PHP/JS) :

```
make install
```

> Cela va construire les conteneurs, installer les dépendances PHP et JS.

---

## 🗄️ Base de données & Fixtures

Créer la base et charger les données de démo (12 produits) :

```
make db
```

ou étape par étape :

```
docker compose exec -u www-data app php bin/console doctrine:database:create
docker compose exec -u www-data app php bin/console doctrine:schema:create
docker compose exec -u www-data app php bin/console doctrine:fixtures:load -n
```

---

## 🎨 Compilation des assets

Compiler les assets (SCSS, JS avec Bootstrap via Webpack Encore) :

```
docker compose run --rm node yarn encore dev
```

Pour un build optimisé (prod) :

```
docker compose run --rm node yarn encore production
```

---

## 🚀 Lancer le projet

Démarrer l’environnement Docker :

```
make start
```

Accéder à l’application :

- Front : [http://localhost:8000](http://localhost:8000)  
- Backoffice (EasyAdmin) : [http://localhost:8000/admin](http://localhost:8000/admin)

credentials :
- **Utilisateur** : `admin`
- **Mot de passe** : `password`

---

## 🧪 Lancer les tests

### Tests unitaires
```
make test
```

---

## 🔑 Accès à l’administration

Connexion à l’espace d’administration EasyAdmin :

- **Utilisateur** : \`admin\`  
- **Mot de passe** : \`password\`  

---

## 🌐 API (produits en JSON)

Une API est disponible

📍 Liste des produits en JSON :
http://localhost:8000/api/products

---

## 📊 Export CSV des produits

Une commande permet d’exporter l’ensemble des produits dans un fichier CSV :

```
docker compose exec -u www-data app php bin/console app:export:products-csv
```

Le fichier est généré dans :

```
var/export/products_YYYYmmdd_HHMMSS.csv
```

---

## 📂 Structure du projet

- \`src/Entity\` → entités Doctrine (\`Product\`, etc.)
- \`src/Service/CartService.php\` → gestion du panier
- \`src/Controller/Front\` → controllers front office
- \`src/Controller/CartController.php\` → panier
- \`src/Controller/CartWidgetController.php\` → pastille panier (header)
- \`src/EventListener/ProductSlugListener.php\` → slug auto produit
- \`templates/front/\` → vues front
- \`templates/cart/\` → vues panier
- \`tests/\` → tests unitaires et fonctionnels
- \`docker-compose.yml\` & \`Dockerfile\` → environnement Docker
- \`Makefile\` → raccourcis pour installation/lancement

