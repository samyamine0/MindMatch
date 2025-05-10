<?php
header("Content-Type: application/json");

$sessionId = $_POST["session_id"] ?? null;
$question = trim($_POST["question"] ?? "");

if (!$sessionId || $question === "") {
    echo json_encode(["success" => false, "error" => "Session ID ou question manquant"]);
    exit;
}

$sessionFile = "../data/session_$sessionId.json";

if (!file_exists($sessionFile)) {
    echo json_encode(["success" => false, "error" => "Session introuvable"]);
    exit;
}

// Charger la session
$sessionData = json_decode(file_get_contents($sessionFile), true);

// Ajouter la question
$sessionData["questions"][] = $question;

// Générer une réponse aléatoire
$reponses_possibles = ["Oui", "Non", "Je ne sais pas"];
$reponse = $reponses_possibles[array_rand($reponses_possibles)];
$sessionData["reponses"][] = $reponse;

// 🔄 Gérer le changement de joueur actif
if (!isset($sessionData["joueur_actif"])) {
    $sessionData["joueur_actif"] = "joueur_1"; // init si absent
} else {
    $sessionData["joueur_actif"] = $sessionData["joueur_actif"] === "joueur_1" ? "joueur_2" : "joueur_1";
}

// Sauvegarder
file_put_contents($sessionFile, json_encode($sessionData, JSON_PRETTY_PRINT));

// Répondre au client
echo json_encode([
    "success" => true,
    "question" => $question,
    "reponse" => $reponse,
    "joueur_suivant" => $sessionData["joueur_actif"]
]);
?>
