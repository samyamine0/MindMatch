//creer session
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("create-session-form");

    if (form) {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const res = await fetch("api/create_session.php", {
                method: "POST"
            });

            const data = await res.json();

            if (data.success) {
                alert("Session créée ! ID : " + data.sessionId);
            } else {
                alert("Erreur lors de la création de la session.");
            }
        });
    }
});

//join session
document.addEventListener("DOMContentLoaded", function () {
    const joinForm = document.getElementById("join-session-form");

    if (joinForm) {
        joinForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            const sessionId = document.getElementById("session-id").value;

            const res = await fetch("api/join_session.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "session_id=" + encodeURIComponent(sessionId)
            });

            const data = await res.json();

            if (data.success) {
                alert("Session rejointe avec succès ! Joueurs : " + data.joueurs.join(", "));
                window.location.href = "game.php?session=" + sessionId;
            } else {
                alert("Erreur : " + data.error);
            }
        });
    }
});

//update session
function getSessionIdFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get("session");
}

function updateSessionInfo() {
    const sessionId = getSessionIdFromURL();

    if (!sessionId) return;

    fetch("api/get_updates.php?session_id=" + encodeURIComponent(sessionId))
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const session = data.data;
                const joueurActifElem = document.getElementById("joueur-actif");
                if (joueurActifElem && session.joueur_actif) {
                    joueurActifElem.textContent = session.joueur_actif;
                }

                const etatElem = document.getElementById("etat");
                const joueursElem = document.getElementById("joueurs");
                const questionsElem = document.getElementById("questions");

                if (etatElem) etatElem.textContent = session.etat ?? "Inconnu";
                if (joueursElem) joueursElem.textContent = session.joueurs?.join(", ") ?? "En attente...";
                if (questionsElem && Array.isArray(session.questions)) {
                    questionsElem.innerHTML = session.questions.map(q => `<li>${q}</li>`).join("");
                }
            }
        })
        .catch(() => {
            // Silencieusement ignorer l'erreur pour ne pas spammer la console
        });
}


// Appelle la fonction toutes les 2 secondes
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname.endsWith("game.php")) {
        setInterval(updateSessionInfo, 2000);
    }
});

//poser des questions
document.addEventListener("DOMContentLoaded", function () {
    const askForm = document.getElementById("ask-question-form");

    if (askForm) {
        askForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            const sessionId = getSessionIdFromURL();
            const questionInput = document.getElementById("question-text");
            const question = questionInput.value.trim();

            if (!question) return;

            const res = await fetch("api/ask_question.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `session_id=${encodeURIComponent(sessionId)}&question=${encodeURIComponent(question)}`
            });

            const data = await res.json();

            if (data.success) {
                questionInput.value = ""; // vide le champ
                // Tu peux afficher la réponse côté client si tu veux
                alert(`Réponse : ${data.reponse} \nProchain joueur : ${data.joueur_suivant}`);
            } else {
                alert("Erreur : " + data.error);
            }
        });
    }
});

