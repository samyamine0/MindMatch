<?php
header("Content-Type: application/json");

$sessionId = $_POST["session_id"] ?? null;

if (!$sessionId) {
    echo json_encode(["success" => false, "error" => "Session ID manquant"]);
    exit;
}

$sessionFile = "../data/session_$sessionId.json";

if (!file_exists($sessionFile)) {
    echo json_encode(["success" => false, "error" => "Session introuvable"]);
    exit;
}

// Charger la session existante
$sessionData = json_decode(file_get_contents($sessionFile), true);

// Ajouter un deuxième joueur si pas déjà présent
if (!isset($sessionData["joueurs"])) {
    $sessionData["joueurs"] = [];
}
if (count($sessionData["joueurs"]) < 2) {
    $sessionData["joueurs"][] = "joueur_" . count($sessionData["joueurs"]) + 1;
    $sessionData["etat"] = "en_cours";

    // Sauvegarder les modifications
    file_put_contents($sessionFile, json_encode($sessionData, JSON_PRETTY_PRINT));

    echo json_encode(["success" => true, "joueurs" => $sessionData["joueurs"]]);
} else {
    echo json_encode(["success" => false, "error" => "Session complète"]);
}
?>
