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
MindMatch/
├── index.html              # Page d'accueil (création / entrée de session)
├── game.php                # Page de jeu principale
├── style.css               # Feuille de style
├── game.js                 # JS principal pour le jeu
├── session_manager.php     # Gestion des sessions (création / jonction)
├── api/
│   ├── ask_question.php    # Enregistrement des questions
│   ├── get_updates.php     # Rafraîchissement des données en temps réel
│   └── end_game.php        # Nettoyage / fin de session
├── data/
│   └── sessions.json       # Stockage temporaire des parties
└── README.md               # Documentation du projet
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

## 🛠️ À venir (idées d'améliorations)

- 📈 Système de score
- 📊 Statistiques de parties
- 🖌️ Dessins ou indices visuels
- 🔄 Mode solo avec pseudo-IA
- 💬 Chat en temps réel entre les joueurs

## 👨‍💻 Auteurs

Projet développé dans le cadre de la L3 Informatique – Université Sorbonne Paris Nord (2024-2025)  
En binôme avec : HALIT Samy 12200614  
Encadré par Sylvain PERIFEL.

---

> “Deviner, c’est penser à travers les mots des autres.” – MindMatch
