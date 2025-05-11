<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$sessionId = $data['sessionId'] ?? null;
$question = $data['question'] ?? null;
$response = $data['response'] ?? null;

$file = '../data/sessions.json';
if (!file_exists($file)) {
    echo json_encode(['error' => 'Fichier sessions.json introuvable']);
    exit;
}

$sessions = json_decode(file_get_contents($file), true);

if (!isset($sessions[$sessionId])) {
    echo json_encode(['error' => 'Session introuvable']);
    exit;
}

// Ajouter une nouvelle question
if ($question !== null) {
    $sessions[$sessionId]['questions'][] = $question;
    $sessions[$sessionId]['responses'][] = null;
}

// Ajouter une réponse à la dernière question
if ($response !== null) {
    $index = count($sessions[$sessionId]['responses']) - 1;
    if ($index >= 0) {
        $sessions[$sessionId]['responses'][$index] = $response;
    }
}

// Sauvegarde
file_put_contents($file, json_encode($sessions, JSON_PRETTY_PRINT));
echo json_encode(['status' => 'ok']);
