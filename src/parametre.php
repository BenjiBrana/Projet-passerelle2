<?php

if (isset($_COOKIE['auth']) && !isset($_SESSION['connect'])) {
    require_once('bdd.php');
    $code = htmlspecialchars($_COOKIE['auth']);
    $req = $bdd->prepare('SELECT COUNT(*) AS codeUnique FROM users WHERE code_unique = ?');
    $req->execute([$code]);

    while ($user = $req->fetch()) {
        if ($user['codeUnique'] == 1) {
            $informations = $bdd->prepare('SELECT * FROM users WHERE code = ?');
            $informations->execute([$code]);
            while ($usersInformations = $informations->fetch()) {
                $_SESSION['connect'] = 1;
                $_SESSION['email']     = $userInformations['email'];
            }
        }
    }
}
