<?php
session_start();

require_once('src/bdd.php');
require_once('src/parametre.php');

$title = "Accueil";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?> | ARCC</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="public/design/css/default.css">
    <link rel="apple-touch-icon" sizes="180x180" href="public/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="public/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="public/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <script src="https://cdn.tiny.cloud/1/eerzdp30ehig6yl7bqqz0yp0mmveajbvuw72h8pz9u7fwvrq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="bg-primary text-dark">
    <header class="header flexCenter w-100 mx-0">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <div class="btnMenu">
                <button class="burger" type="button">
                    <span class="bar"></span>
                </button>
            </div>
            <div class="navbarTitle pt-5">
                <h1 class="text-center"> <b>A</b>chat <b>R</b>entable <b>C</b>arte <b>C</b>adeau</h1>
            </div>
            <div class="navbarLogo">
                <img class="logo" src="public/assets/img/Logo.png" alt="Logo">
            </div>
        </nav>
    </header>
    <section class="container">

        <h2>Bonjour et Bienvenue</h2>
        <p>
            Ce blog vous montre les bénéfices pour vous de changer votre mode de paiement actuel par cartes-cadeaux.
            <br><br>
            Cette méthode est à long terme et fonctionne vraiment! De nombreuses familles ont ainsi pu accroître leur pouvoir d'achat.
            <br><br>
            C'est un concept simple, efficace et français !
            <br><br>
            N'attendez plus pour changer votre vie c'est une opportunité en or qui vous est proposée !
        </p>

        <div class="flexColumn">
            <p class="pt-5">Deux possibilités s'offrent à vous :<br>
            <ul class="flex gap-2">
                <li>Soit utilisez le bouton rouge (Inscription) pour voir comment vous pouvez améliorer votre futur.</li>
                <li>Soit utilisez le bouton bleu (Connexion) pour trouver toutes les nouvelles en rapport avec le système de cartes-cadeaux.</li>
            </ul>
            </p>
            <div class="flexRow">
                <button class="btn btn-danger btn-lg"><a href="view/inscription.php">Inscription</a></button>
                <button class="btn btn-persoBlue btn-lg"><a href="view/connexion.php">Connexion</a></button>
            </div>
        </div>
    </section>
</body>

</html>