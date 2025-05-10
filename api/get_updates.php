<?php
header("Content-Type: application/json");

// Récupération de l'ID de session depuis l'URL (GET)
$sessionId = $_GET["session_id"] ?? null;

if (!$sessionId) {
    echo json_encode(["success" => false, "error" => "Session ID manquant"]);
    exit;
}

$sessionFile = "../data/session_$sessionId.json";

if (!file_exists($sessionFile)) {
    echo json_encode(["success" => false, "error" => "Session introuvable"]);
    exit;
}

// Charger et retourner les données de session
$sessionData = json_decode(file_get_contents($sessionFile), true);

echo json_encode([
    "success" => true,
    "data" => $sessionData
]);
?>
