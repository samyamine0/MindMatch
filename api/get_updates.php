<?php
header('Content-Type: application/json');

$sessionId = $_GET['sessionId'] ?? null;
$role = $_GET['role'] ?? null;

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

$session = $sessions[$sessionId];

if ($role === 'responder') {
    $lastQuestion = end($session['questions']) ?: '';
    echo json_encode(['question' => $lastQuestion]);
} elseif ($role === 'asker') {
    $lastResponse = end($session['responses']) ?: '';
    echo json_encode(['response' => $lastResponse]);
} else {
    echo json_encode(['error' => 'Role invalide']);
}
