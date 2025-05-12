<?php
header('Content-Type: application/json');

$session_id = $_GET['sessionId'] ?? null;
$file = '../data/sessions.json';

if (!$session_id) {
    echo json_encode(value: ['error' => 'ID de session manquant']);
    exit;
}

if(!file_exists($file)) {
    echo json_encode(['error' => 'Fichier sessions.json introuvable']);
    exit;
}

$sessions = json_decode(file_get_contents($file), true);

if(!isset($sessions[$session_id])) {
    echo json_encode(['error' => 'Session non trouvée']);
    exit;
}

// Marque la session comme gagnée
$sessions[$session_id]['won'] = true;
file_put_contents($file, json_encode($sessions, JSON_PRETTY_PRINT));
echo json_encode(['status' => 'success']);