<?php
header('Content-Type: application/json');

$sessionId = $_GET['sessionId'] ?? null;
$file = '../data/sessions.json';

if (!$sessionId) {
    echo json_encode(['error' => 'ID de session manquant']);
    exit;
}

if (!file_exists($file)) {
    echo json_encode(['error' => 'Fichier sessions.json introuvable']);
    exit;
}

$sessions = json_decode(file_get_contents($file), true);

if (!isset($sessions[$sessionId])) {
    echo json_encode(['error' => 'Session non trouvée']);
    exit;
}

unset($sessions[$sessionId]);
file_put_contents($file, json_encode($sessions, JSON_PRETTY_PRINT));

echo json_encode(['status' => 'ended']);
