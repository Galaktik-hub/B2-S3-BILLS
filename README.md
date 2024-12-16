# B.I.L.L.S. (💳 Bilan des Impayés et des Lettres de Licenses avec Statistiques 📊)

## Contexte du Projet

🎓 Ce projet a été réalisé dans le cadre du module **"Qualité de développement"** à l'Université Gustave Eiffel, pour répondre aux besoins d'une banque souhaitant améliorer la gestion des paiements par cartes bancaires pour ses clients professionnels (e-commerce, commerçants, artisans, etc.). 

Le portail développé offre des fonctionnalités telles que :

- 🧾 Suivi des activités monétiques (transactions, impayés) pour les entreprises.
- 📂 Extraction de données au format CSV et XLS.
- 🖨️ Génération d'états et de rapports en PDF.

Le projet a été conduit selon une méthodologie Agile Scrum, avec des rôles définis au sein de l'équipe : Scrum Master, Technical Leader, Développeurs et Testeurs.

---

## 🌐 Projet final

Vous pouvez retrouver le projet final hébergé à l'adresse ci-dessous :

🔗 [https://bills.julien-synaeve.fr](https://bills.julien-synaeve.fr)

**Compte de démonstration** :
- 🧑‍💻 Nom d'utilisateur : `client`
- 🔒 Mot de passe : `client`

---

## ✨ Fonctionnalités

- **Portail utilisateur** : Vue des transactions et activités monétiques.
- **Exportations** : Fichiers CSV, XLS et rapports PDF pour une analyse avancée.
- **Mails** : Un mail de bienvenue est envoyé à l'utilisateur, lui permettant de changer son mot de passe. Fonction d'oubli de mot de passe incluse.

---

## 🛠️ Technologies Utilisées

Les technologies et outils utilisés incluent :
- **Back-end** : PHP/MySQL.
- **Front-end** : HTML/CSS & JS.
- **Bases de données** : MySQL.
- **Modules & Bibliothèques** : PHPMailer, AgGrid, PlotlyJS.

---

## 🎥 Manuel utilisateur (vidéo)

- [https://www.youtube.com/watch?v=WZsEtAbGReo](https://www.youtube.com/watch?v=WZsEtAbGReo)

---

## 🧑‍💻 Développement à Partir du Code Source

### 1️⃣ **Prérequis**
- Serveur PHP.
- Serveur MySQL.
- [Composer](https://getcomposer.org/download/).

### 2️⃣ **Installation**
- Clonez ce dépôt : 
```bash
git clone https://github.com/Galaktik-hub/B2-S3-BILLS.git
```
- Importez la base de données MySQL à l'aide du fichier database/banque.sql.


### 3️⃣ **Fichiers de configuration** :

Vous devez créer plusieurs fichiers de configuration pour établir les différentes connexions nécessaires.
    
- Fichier `credentials/mailcredentials.php`
```php
<?php

$mailsae = '[email_bot@example.com]';   // L'email qui sera utilisé pour envoyer les mails 
$mdp = '[clé secrete]';
```

- Fichier `include/parametre.php`
```php
<?php

$host = "127.0.0.1";    // L'hôte pour la connexion à la base de données
$user = "root";         // Le nom d'utilisateur utilisé pour s'authentifier à la base de données
$pwd = "";              // Le mot de passe utilisé pour s'authentifier à la base de données
$db = "banque";         // Le nom de la base de données
```


### 4️⃣ **Build Composer** :

Les fonctionnalités d'envoi d'email reposent sur le module [PHPMailer](https://github.com/PHPMailer/PHPMailer). Pour plus d'informations, n'hésitez pas à aller voir la page GitHub associée, sinon voici un résumé de la configuration de PHPMailer :
- Pour ce faire, vous devez avoir installé [Composer](https://getcomposer.org/download/).
- Placez vous dans le dossier `mail` puis lancez la commande :
```bash
composer require phpmailer/phpmailer
```
- Vous devriez voir un dossier `vendor`, un fichier `composer.json` et un fichier `composer.lock`. Cela signifie que le build s'est bien passé. 🚀 Si vous rencontrez quelconque problème, veuillez vous référer à la page GitHub de [PHPMailer].(https://github.com/PHPMailer/PHPMailer).


### 5️⃣ **Démarrage** :
   - Lancez les serveurs locaux (PHP & MySQL).
   - 🎉 Vous êtes prêts !

## 🙌 Crédit

Ce projet a été réalisé par une équipe d'étudiants en informatique :
- [TELLE Alexis](https://www.linkedin.com/in/alexis-telle)
- [SYNAEVE Julien](https://www.linkedin.com/in/julien-synaeve)
- [ELANKEETHAN Kirushikesan](https://www.linkedin.com/in/elankeethan)
- [CHAMPAULT Alexis](https://www.linkedin.com/in/champaulta)
- [SANTOS Victor](https://www.linkedin.com/in/victorsts)
