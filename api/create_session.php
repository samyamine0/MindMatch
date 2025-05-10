<?php
header("Content-Type: application/json");

// Création d'un ID unique aléatoire
function generateSessionId($length = 6) {
    return strtoupper(substr(bin2hex(random_bytes($length)), 0, $length));
}

$sessionId = generateSessionId();

// Mot mystère par défaut
$motMystere = "banane";

// Structure de la session
$sessionData = [
    "id" => $sessionId,
    "mot_mystere" => $motMystere,
    "questions" => [],
    "reponses" => [],
    "etat" => "en attente",
    "joueurs" => ["joueur_1"]
];

// Créer le dossier data s'il n'existe pas
if (!file_exists("data")) {
    mkdir("data", 0777, true);
}

// Sauvegarder la session dans un fichier JSON individuel
file_put_contents("../data/session_$sessionId.json", json_encode($sessionData, JSON_PRETTY_PRINT));

// Réponse au client
echo json_encode([
    "success" => true,
    "sessionId" => $sessionId
]);
?>
