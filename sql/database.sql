CREATE DATABASE site_web;

USE site_web;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    tel VARCHAR(15),
    photo_de_profil INT,
    mot_de_passe VARCHAR(255) NOT NULL,
    adresse VARCHAR(255)
);