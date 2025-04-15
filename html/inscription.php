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
        $donnees = json_decode($contenu, true) ?? ['user' => [], 'admin' => []];
    }

    foreach (array_merge($donnees['user'] ?? [], $donnees['admin'] ?? []) as $utilisateur) {
        if (strtolower($utilisateur['email']) === strtolower($email)) {
            $_SESSION['inscription_error'] = "Cet email est déjà utilisé.";
            header("Location: sign-up.php");
            exit();
        }
    }

    // Génération de l'ID
    $max_id = 0;
    
    // Parcourir les admins pour trouver l'ID max
    foreach ($donnees['admin'] ?? [] as $admin) {
        if (isset($admin['id_user']) && intval($admin['id_user']) > $max_id) {
            $max_id = intval($admin['id_user']);
        }
    }
    
    // Parcourir les users pour trouver l'ID max
    foreach ($donnees['user'] ?? [] as $user) {
        if (isset($user['id_user']) && intval($user['id_user']) > $max_id) {
            $max_id = intval($user['id_user']);
        }
    }
    
    $nouvel_id = strval($max_id + 1); // Nouvel ID (le max + 1)

    // Création utilisateur
    $utilisateur = [
        'id_user' => $nouvel_id, // Ajout de l'ID généré
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
        'voyage' => [ // Ajout de la structure voyage pour cohérence
            'consultes' => [],
            'achetes' => []
        ]
    ];

    $donnees['user'][] = $utilisateur;

    if (file_put_contents($fichier_json, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
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