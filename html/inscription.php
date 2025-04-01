<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];

    // Validation des données
    if ($mot_de_passe !== $confirmation_mot_de_passe) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Hachage du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Création d'un tableau avec les données de l'utilisateur
    $utilisateur = [
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mot_de_passe' => $mot_de_passe_hash
    ];

    // Chemin du fichier JSON
    $fichier_json = '../json/utilisateurs.json';

    // Lecture du fichier JSON existant
    if (file_exists($fichier_json)) {
        $donnees_existantes = file_get_contents($fichier_json);
        $utilisateurs = json_decode($donnees_existantes, true);
    } else {
        $utilisateurs = [];
    }

    // Ajout du nouvel utilisateur
    $utilisateurs[] = $utilisateur;

    // Encodage des données en JSON
    $donnees_json = json_encode($utilisateurs, JSON_PRETTY_PRINT);

    // Écriture des données dans le fichier JSON
    if (file_put_contents($fichier_json, $donnees_json)) {
        header("Location: sign-up.php");
    } else {
        header("Location: sign-up.php");
    }
}
?>