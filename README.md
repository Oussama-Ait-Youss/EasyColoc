## 🏠 EasyColoc - Gestion de Colocation Simplifiée

EasyColoc est une application web monolithique conçue pour simplifier la gestion financière et organisationnelle au sein d'une colocation. Elle permet de suivre les dépenses communes, de calculer automatiquement les dettes et de maintenir une transparence totale entre les membres.
## 🚀 Fonctionnalités Clés
## 👤 Gestion des Utilisateurs & Rôles

    Système d'Authentification : Inscription et connexion sécurisées via Laravel Breeze.

    Rôles Dynamiques :

        Admin Global : Premier utilisateur inscrit, il gère les statistiques et la modération (bannissement).

        Owner : Créateur d'une colocation, il gère les membres et les catégories.

        Member : Rejoint une colocation via invitation pour participer aux dépenses.

    Système de Réputation : Attribution de points (+1/-1) basés sur le comportement financier lors du départ d'une colocation.

## 💸 Gestion Financière

    Suivi des Dépenses : Ajout de dépenses avec montant, date et catégorie.

    Calcul Automatique : Génération instantanée des soldes individuels et de la vue "Qui doit à qui".

    Remboursements : Option "Marquer comme payé" pour simplifier la réduction des dettes.

    Filtrage Mensuel : Visualisation des dépenses mois par mois pour une meilleure gestion budgétaire.

## 🤝 Organisation de la Coloc

    Invitations : Système d'invitation sécurisé par token unique envoyé par email.

    Règle de l'Unicité : Limitation stricte à une seule colocation active par utilisateur.

## 🛠️ Stack Technique

    Framework : Laravel (Architecture MVC)

    Authentification : Laravel Breeze / Jetstream

    Base de données : MySQL ou PostgreSQL

    ORM : Eloquent (Relations hasMany et belongsToMany)

## 📋 Scénarios d'Implémentation Critiques

    Gestion des Dettes au Départ : Si un membre quitte avec une dette, sa réputation est impactée. Si l'Owner retire un membre endetté, la dette est imputée à l'Owner.

    Protection Multi-Coloc : Empêchement technique de rejoindre ou créer une nouvelle colocation tant qu'une colocation actuelle est active.

    Promotion Admin : Automatisation du rôle Admin Global pour le premier utilisateur inscrit sur la plateforme.

## 📂 Installation

    Clonez le dépôt :
    Bash

    git clone https://github.com/Oussama-Ait-Youss/EasyColoc

    Installez les dépendances :
    Bash

    composer install
    npm install && npm run dev

    Configurez votre fichier .env et générez la clé :
    Bash

    php artisan key:generate

    Lancez les migrations :
    Bash

    php artisan migrate

## 🎯 Objectif du Projet

- L'objectif est de fournir une solution robuste pour éviter les conflits financiers en colocation grâce à une automatisation des calculs et une transparence des échanges.