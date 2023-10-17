<?php

session_start();


$title = "Connexion";

ob_start();

require_once('../src/parametre.php');
require_once('../src/bdd.php');



if (!empty($_POST['email']) && !empty($_POST['password'])) {


    $email            = htmlspecialchars($_POST['email']);
    $password        = htmlspecialchars($_POST['password']);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header('location: connexion.php?error=1&message=Votre adresse email est invalide.');
        exit();
    }


    $password = "aq1" . sha1($password . "123") . "25";


    $req = $bdd->prepare('SELECT COUNT(*) as testEmail FROM users WHERE email = ?');
    $req->execute([$email]);

    while ($emailVerification = $req->fetch()) {

        if ($emailVerification['testEmail'] != 1) {

            header('location: connexion.php?error=1&message=Impossible de vous authentifier correctement, une erreur est présente.');
            exit();
        }
    }


    $req = $bdd->prepare('SELECT * FROM users WHERE email = ?');
    $req->execute([$email]);

    while ($user = $req->fetch()) {

        if ($password == $user['password']) {

            $_SESSION['connect'] = 1;
            $_SESSION['email']     = $user['email'];
            $_SESSION['type']     = $user['type'];
            $_SESSION['id']     = $user['id'];
            $_SESSION['last_name']     = $user['last_name'];
            $_SESSION['first_name']     = $user['first_name'];

            if (isset($_POST['auto'])) {

                setcookie('auth', $user['codeUnique'], time() + 365 * 24 * 3600, '/', null, false, true);
            }

            header('location: blog.php');
            exit();
        }
    }
}
?>

    <?php if (isset($_SESSION['connect'])) {


        header('location: blog.php');
        exit();
    } else { ?>
<section class="container flexCenter">
    <div class="card-systeme border my-2 mx-auto flexColumn">
        <div class="card-image card-image-connexion">
        </div>
        <h2 class="card-heading text-center">
            Connexion
        </h2>
        <?php if (isset($_GET['error'])) {

            if (isset($_GET['message'])) {
                echo '<div class="alert error red">' . htmlspecialchars($_GET['message']) . '</div>';
            }
        } ?>
        <form class="card-form flexColumn p2" method="post" action="connexion.php">
            <div class="input flexColumn">
                <label for="email" class="input-label text-center">Email</label>
                <input class="input-field" id="email" type="email" name="email" placeholder="exemple@gmail.com" required />
            </div>
            <div class="input flexColumn">
                <label for="password" class="input-label text-center">Mot de passe</label>
                <input class="input-field" id="password" type="password" name="password" placeholder="Saisir un mot de passe" required />
            </div>

            <div class="action flexColumn">
                <button type="submit" class="action-button btn btn-lg btn-success p-4">S'identifier</button>
            </div>
            <label id="option">
                <input type="checkbox" name="auto" checked />
                Se souvenir de moi
            </label>
        </form>
        <?php } ?>
        <button class="btn btn-persoBlue btn-lg flexColumn mb-5">
            <a href="../index.php">Retour</a>
        </button>
    </div>
</section>

<?php
$content = ob_get_clean();

require('base.php');
?>