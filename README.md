# 🎯 MindMatch – Jeu Web de Déduction à Deux Joueurs

Bienvenue sur **MindMatch**, un jeu en ligne simple et interactif où deux joueurs s'affrontent pour faire deviner un mot mystère par le biais de questions fermées !

## 🚀 Fonctionnalités principales

- 👤 **Mode 2 joueurs** (via code de session unique)
- 💬 **Interaction en temps réel** via AJAX
- ❓ **Questions fermées** (Oui / Non / Je ne sais pas)
- 🔐 **Système de session** pour synchroniser les parties
- 🧠 **Réflexion et stratégie** pour deviner le mot secret

## 🧱 Technologies utilisées

- `HTML` / `CSS` pour la structure et le style
- `JavaScript` (vanilla) pour la dynamique côté client
- `PHP` pour la logique serveur et la gestion des sessions
- `JSON` pour le stockage temporaire des données

## 📂 Arborescence du projet

```
.
├── index.html # Page d'accueil avec formulaires de création/join
├── asker.html # Interface du poseur de questions
├── responder.html # Interface du répondant
├── style.css # Feuille de styles CSS
├── game.js # Script principal JS (client)
├── session_manager.php # Création de session côté serveur
├── data/
│ └── sessions.json # Fichier JSON contenant toutes les sessions
└── api/
├── ask_question.php # Envoi de questions/réponses
├── get_updates.php # Récupération des mises à jour pour chaque rôle
├── end_game.php # Gestion de l’abandon
└── win_game.php # Gestion de la victoire
```

## ⚙️ Installation locale

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/votre-utilisateur/mindmatch.git
   cd mindmatch
   ```

2. Démarrez un serveur local PHP :
   ```bash
   php -S localhost:8000
   ```

3. Accédez au jeu dans votre navigateur :
   ```
   http://localhost:8000
   ```

## 🧪 Comment jouer

### Joueur A :
- Se rend sur la page d'accueil
- Choisit un mot secret
- Reçoit un code de session à partager

### Joueur B :
- Entre le code reçu sur la page d'accueil
- Rejoint la session pour poser des questions

### Le but :
Faire deviner le mot mystère en posant des questions fermées et en interprétant les réponses du joueur A.

## 👨‍💻 Auteurs

Projet développé dans le cadre de la L3 Informatique – Université Sorbonne Paris Nord (2024-2025)  
En binôme avec : HALIT Samy 12200614  
Encadré par Sylvain PERIFEL.

---

> “Deviner, c’est penser à travers les mots des autres.” – MindMatch
