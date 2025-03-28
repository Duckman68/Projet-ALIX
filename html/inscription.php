<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmation = $_POST['confirmation_mot_de_passe'];

    // Validation
    if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
        $_SESSION['inscription_error'] = "Tous les champs sont obligatoires.";
        header("Location: sign-up.php");
        exit();
    }

    if ($mot_de_passe !== $confirmation) {
        $_SESSION['inscription_error'] = "Les mots de passe ne correspondent pas.";
        header("Location: sign-up.php");
        exit();
    }


    // Vérification email existant
    $fichier_json = '../json/utilisateurs.json';
    $donnees = [];

    if (file_exists($fichier_json)) {
        $contenu = file_get_contents($fichier_json);
        $donnees = json_decode($contenu, true) ?? ['user' => []];
    }

    foreach ($donnees['user'] ?? [] as $utilisateur) {
        if (strtolower($utilisateur['email']) === strtolower($email)) {
            $_SESSION['inscription_error'] = "Cet email est déjà utilisé.";
            header("Location: sign-up.php");
            exit();
        }
    }

    // Création utilisateur
    $utilisateur = [
        'role' => "membre",
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mot_de_passe' => $mot_de_passe,
        'phone' => "",
        'address' => "",
        'sign-date' => date("d/m/Y"),
        'login-date' => "",
        'historique' => "",
        'pp' => "../img/default.png",
    ];

    $donnees['user'][] = $utilisateur;

    if (file_put_contents($fichier_json, json_encode($donnees, JSON_PRETTY_PRINT))) {
        $_SESSION['inscription_success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['inscription_error'] = "Erreur lors de l'enregistrement. Veuillez réessayer.";
        header("Location: sign-up.php");
        exit();
    }
}

header("Location: sign-up.php");
exit();
?>