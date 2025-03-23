<?php
session_start(); // Démarre la session

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Chemin du fichier JSON
    $fichier_json = '../json/utilisateurs.json';

    // Vérifie si le fichier JSON existe
    if (file_exists($fichier_json)) {
        // Lecture du fichier JSON
        $donnees_json = file_get_contents($fichier_json);
        $utilisateurs = json_decode($donnees_json, true);

        // Recherche de l'utilisateur par email
        $utilisateur_trouve = null;
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['email'] === $email) {
                $utilisateur_trouve = $utilisateur;
                break;
            }
        }

        // Vérification du mot de passe
        if ($utilisateur_trouve && password_verify($mot_de_passe, $utilisateur_trouve['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['utilisateur'] = $utilisateur_trouve; // Stocke les informations de l'utilisateur dans la session
            header("Location: user.php"); // Redirige vers la page utilisateur
            exit();
        } else {
            // Échec de la connexion
            $_SESSION['erreur'] = "Adresse e-mail ou mot de passe incorrect.";
            header("Location: login.php"); // Redirige vers la page de connexion
            exit();
        }
    } else {
        $_SESSION['erreur'] = "Aucun utilisateur enregistré.";
        header("Location: login.php"); // Redirige vers la page de connexion
        exit();
    }
}
?>