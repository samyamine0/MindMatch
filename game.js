// ----- Gestion des formulaires dans index.html -----

document.addEventListener("DOMContentLoaded", () => {
    const createForm = document.getElementById("create-session-form");
    const joinForm = document.getElementById("join-session-form");

    if (createForm) {
        createForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const word = document.getElementById("secret-word").value.trim();

            fetch("session_manager.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ word })
            })
            .then(res => res.json())
            .then(data => {
                const sessionId = data.sessionId;
                alert("Session créée. Donne cet ID à ton ami : " + sessionId);
                window.location.href = `responder.html?id=${sessionId}&word=${encodeURIComponent(word)}`;
            });
        });
    }

    if (joinForm) {
        joinForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const sessionId = document.getElementById("session-id").value.trim();
            window.location.href = `asker.html?id=${sessionId}`;
        });
    }

    // ----- ASKERS -----
    if (document.body.id === "asker-page") {
        const urlParams = new URLSearchParams(window.location.search);
        const sessionId = urlParams.get('id');
        let questionCount = 1;
        let guessCount = 1;

        const questionBtn = document.getElementById("send-question-btn");
        const guessBtn = document.getElementById("check-guess-btn");

        sessionCheckInterval = setInterval(() => fetchLastResponse(sessionId), 1000);


        questionBtn?.addEventListener("click", () => {
            const question = document.getElementById("question-input").value.trim();
            if (!question || questionCount > 10) return;

            fetch("api/ask_question.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ sessionId, question })
            }).then(() => {
                document.getElementById("question-input").value = "";
                questionCount++;
                document.getElementById("question-count").innerText = questionCount;
                if (questionCount > 10) {
                    alert("Tu as atteint la limite de 10 questions !");
                }
            });
        });

        guessBtn?.addEventListener("click", () => {
            const guess = document.getElementById("guess-input").value.trim().toLowerCase();
            if (!guess || guessCount > 5) return;

            fetch(`data/sessions.json`)
                .then(res => res.json())
                .then(data => {
                    const correctWord = (data[sessionId]?.word || "").toLowerCase();
                    const feedback = document.getElementById("guess-feedback");

                    if (guess === correctWord) {
                        feedback.innerText = "🎉 Félicitations ! Tu as trouvé le mot.";
                        feedback.style.color = "green";
                        endGame(sessionId);
                    } else {
                        guessCount++;
                        document.getElementById("guess-number").innerText = guessCount;
                        if (guessCount > 5) {
                            feedback.innerText = "😢 Tu as épuisé tes 5 essais.";
                            feedback.style.color = "red";
                            endGame(sessionId);
                        } else {
                            feedback.innerText = "❌ Mauvais mot. Réessaie.";
                            feedback.style.color = "#7e57c2";
                        }
                    }
                });
        });

        window.abandonGame = function () {
            if (!confirm("Tu es sûr de vouloir abandonner la partie ?")) return;

            fetch(`api/end_game.php?sessionId=${sessionId}`)
                .then(() => {
                    alert("Tu as abandonné la partie.");
                    window.location.href = "index.html";
                });
        };
    }

    // ----- RESPONDERS -----
    if (document.body.id === "responder-page") {
        const urlParams = new URLSearchParams(window.location.search);
        const sessionId = urlParams.get('id');
        const word = urlParams.get('word');
        window.sessionId = sessionId;

        document.getElementById('word-display').innerText = word;

        sessionCheckInterval = setInterval(() => fetchLastQuestion(sessionId), 1000); 


        window.quitGame = function () {
            if (!confirm("Tu es sûr de vouloir quitter la partie ?")) return;

            fetch(`api/end_game.php?sessionId=${sessionId}`)
                .then(() => {
                    alert("Tu as quitté la partie.");
                    window.location.href = "index.html";
                });
        };
        const quitBtn = document.getElementById("quit-btn");
        quitBtn?.addEventListener("click", () => {
            window.quitGame();
        });

        document.querySelectorAll('button[data-answer]').forEach(btn => {
            btn.addEventListener('click', () => {
                const response = btn.getAttribute('data-answer');
                sendResponse(response);
            });
        });
    }
});

// Commun
function sendResponse(response) {
    fetch("api/ask_question.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ sessionId, response })
    });
}

let sessionCheckInterval = null;


function fetchLastQuestion(sessionId) {
    fetch(`api/get_updates.php?sessionId=${sessionId}&role=responder`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'abandoned') {
                clearInterval(sessionCheckInterval);
                displayNotification("L'Asker a quitté la partie.");
                return;
            }
            document.getElementById("last-question").innerText = data.question || "En attente de question...";
        });
}

function fetchLastResponse(sessionId) {
    fetch(`api/get_updates.php?sessionId=${sessionId}&role=asker`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'abandoned') {
                clearInterval(sessionCheckInterval);
                displayNotification("Le Responder a quitté la partie.");
                return;
            }
            document.getElementById("response-display").innerText = "Réponse : " + (data.response || "...");
        });
}

function displayNotification(message) {
    const notificationDiv = document.getElementById('notification');
    const messageSpan = document.getElementById('notification-message');
    
    messageSpan.innerText = message; // Mettre le message dans le span
    notificationDiv.style.display = 'block'; // Afficher la notification
}


function endGame(sessionId) {
    fetch(`api/end_game.php?sessionId=${sessionId}`);
}