<?php

function supprimer()
{

    require '../src/bdd.php';

    if (!empty($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $req = $bdd->prepare('DELETE FROM articles WHERE id = ?');
        $req->execute(array($id));
        header("Location: admin.php");
    }
}
