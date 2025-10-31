🇫🇷 Projet : Plateforme de location et de vente immobilière 🏡

📋 Description
Ce projet est une application web développée avec Symfony (back-end) et Angular (front-end), permettant la gestion, la location et la vente de biens immobiliers.
Les utilisateurs peuvent consulter, filtrer, réserver ou proposer des logements, tandis que les propriétaires et les administrateurs disposent de fonctionnalités de gestion complètes.

✨ Fonctionnalités principales

👤 Inscription, connexion et gestion des utilisateurs (admin, propriétaire, client, visiteur)
🏠 Ajout, modification et suppression d’annonces immobilières
🔎 Recherche et filtrage par type, localisation, prix et confort
📅 Réservation et suivi des disponibilités
🖼️ Gestion des photos et des informations de contact
🛠️ Interface administrateur pour superviser les données

🧰 Technologies utilisées

Backend : Symfony 7, PHP 8, MySQL, Doctrine ORM
Frontend : Angular 17, TypeScript, HTML, CSS, Bootstrap
Outils : Git, Composer, npm, VS Code, JMerise, StarUML

🚀 Installation du projet

Cloner le dépôt :

git clone https://github.com/nom-utilisateur/nom-du-projet.git


Accéder au dossier :

cd nom-du-projet


Installer les dépendances Symfony :

composer install


Installer les dépendances Angular :

cd frontend
npm install


Configurer la base de données dans .env, puis exécuter :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


Lancer le serveur :

symfony serve
npm start

🧭 Comment utiliser le site

👑 Administrateur
Dispose de tous les droits sur le site.
Peut ajouter, modifier et supprimer les utilisateurs et les logements.
Responsable de la gestion des données, de la communication et du respect des règles du site.

🏰 Propriétaire
Peut gérer ses propres annonces (ajout, modification, suppression).
Peut consulter la liste et les détails des logements, échanger des messages et laisser des avis.
Doit garantir la véracité des informations publiées.

💼 Client
Peut consulter, réserver ou faire une offre sur les logements.
Peut modifier son profil et contacter les propriétaires.
Doit respecter les règles et la courtoisie du site.

🌿 Visiteur
Peut consulter une partie des logements (hors catégorie luxe).
Peut contacter l’administrateur via la page de contact.
Peut s’inscrire pour devenir propriétaire ou client.

📝 Inscription

L’utilisateur doit indiquer :
Nom, prénom, pseudonyme, email, mot de passe (et confirmation), pays, ville, adresse.
Téléphone (obligatoire pour propriétaires).
Date de naissance.

🔑 Connexion

Se fait via email et mot de passe.

----------------------------------------------------------------------

🇬🇧 Project: Real Estate Rental and Sales Platform 🏘️

📋 Description
A web application built with Symfony (backend) and Angular (frontend) for managing property listings for rent and sale.
Users can browse, filter, book, or offer properties, while owners and administrators have full management capabilities.

✨ Key Features

👤 User registration, login, and role management (admin, owner, client, visitor)
🏠 Create, edit, and delete property listings
🔎 Filter and search by type, location, price, and amenities
📅 Manage reservations and availability
🖼️ Upload property photos and view details
🛠️ Admin dashboard for system management

🧰 Technologies Used

Backend: Symfony 7, PHP 8, MySQL, Doctrine ORM
Frontend: Angular 17, TypeScript, HTML, CSS, Bootstrap
Tools: Git, Composer, npm, VS Code, JMerise, StarUML

🚀 Installation

Clone the repository:

git clone https://github.com/username/project-name.git


Go to the project directory:

cd project-name


Install Symfony dependencies:

composer install


Install Angular dependencies:

cd frontend
npm install


Configure the database in .env, then run:

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


Start the servers:

symfony serve
npm start

---------------------------------------------------------------------------

🇺🇦 Проєкт: Платформа оренди та продажу нерухомості 🏡

📋 Опис
Вебзастосунок, створений за допомогою Symfony (бекенд) і Angular (фронтенд), для керування оголошеннями про оренду та продаж житла.
Користувачі можуть переглядати, фільтрувати, бронювати або пропонувати нерухомість, а власники та адміністратори мають розширені можливості управління.

✨ Основні функції

👤 Реєстрація, вхід і керування ролями користувачів (адмін, власник, клієнт, відвідувач)
🏠 Додавання, редагування та видалення оголошень
🔎 Пошук і фільтрація за типом, місцем, ціною та зручностями
📅 Бронювання житла та перевірка доступності
🖼️ Додавання фотографій та перегляд деталей житла
🛠️ Панель адміністратора для керування всією системою

🧰 Використані технології

Бекенд: Symfony 7, PHP 8, MySQL, Doctrine ORM
Фронтенд: Angular 17, TypeScript, HTML, CSS, Bootstrap
Інструменти: Git, Composer, npm, VS Code, JMerise, StarUML

🚀 Встановлення проєкту

Клонувати репозиторій:

git clone https://github.com/username/project-name.git


Перейти до каталогу:

cd project-name


Встановити залежності Symfony:

composer install


Встановити залежності Angular:

cd frontend
npm install


Налаштувати базу даних у .env, потім виконати:

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


Запустити сервери:

symfony serve
npm start

🧭 Як користуватись сайтом

👑 Адміністратор
Має повний доступ до сайту.
Може додавати, редагувати та видаляти користувачів і оголошення.
Відповідає за керування даними, комунікацію та дотримання правил сайту.

🏰 Власник
Може керувати лише власними оголошеннями (додавати, редагувати, видаляти).
Може переглядати список і деталі житла, надсилати повідомлення, залишати відгуки.
Несе відповідальність за достовірність інформації.

💼 Клієнт
Може переглядати, бронювати або робити пропозиції щодо житла.
Може змінювати свій профіль і спілкуватися з власниками.
Повинен дотримуватись правил та етикету спілкування.

🌿 Відвідувач
Може переглядати лише частину оголошень (крім «люксових»).
Може зв’язатися з адміністратором через сторінку контактів.
Може зареєструватися, щоб отримати більше можливостей.

📝 Реєстрація

Під час реєстрації потрібно вказати:
Ім’я, прізвище, псевдонім, email, пароль (і підтвердження), країну, місто, адресу.
Телефон (обов’язковий для власників).
Дату народження.

🔑 Вхід

Для входу потрібні email і пароль.