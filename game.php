<?php
$sessionId = $_GET["session"] ?? null;
if (!$sessionId) {
    die("Aucune session fournie.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MindMatch – Session <?php echo htmlspecialchars($sessionId); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Session ID : <?php echo htmlspecialchars($sessionId); ?></h1>
    <p>État : <strong id="etat">Chargement...</strong></p>
    <p>Joueurs : <strong id="joueurs">Chargement...</strong></p>
    <h2>Questions posées :</h2>
    <ul id="questions">
        <li>Chargement...</li>
    </ul>
    <h2>Poser une question :</h2>
    <p>Joueur actif : <strong id="joueur-actif">Chargement...</strong></p>
    <form id="ask-question-form">
        <input type="text" id="question-text" placeholder="Ta question..." required>
        <button type="submit">Envoyer</button>
    </form>

    <script src="game.js"></script>
</body>
</html>
