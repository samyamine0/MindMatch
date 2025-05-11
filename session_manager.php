<?php
header('Content-Type: application/json');

// Récupérer les données JSON envoyées par le client
$data = json_decode(file_get_contents('php://input'), true);
$word = trim($data['word'] ?? '');

if (empty($word)) {
    http_response_code(400);
    echo json_encode(['error' => 'Mot manquant']);
    exit;
}

// Générer un ID unique de session (ex : X4ZQ1)
function generateSessionId($length = 5) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $id = '';
    for ($i = 0; $i < $length; $i++) {
        $id .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $id;
}

// Charger les sessions existantes
$file = 'data/sessions.json';
if (!file_exists('data')) {
    mkdir('data', 0777, true);
}
$sessions = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

// Créer une nouvelle session avec un ID unique non utilisé
do {
    $sessionId = generateSessionId();
} while (isset($sessions[$sessionId]));

// Ajouter la session
$sessions[$sessionId] = [
    'word' => $word,
    'questions' => [],
    'responses' => [],
    'abandoned' => false,
];

// Sauvegarder
file_put_contents($file, json_encode($sessions, JSON_PRETTY_PRINT));

// Retourner l'ID au client
echo json_encode(['sessionId' => $sessionId]);
