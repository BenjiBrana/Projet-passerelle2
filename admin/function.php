<?php
function supprimer()
{
    require '../src/bdd.php';
    if (!empty($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $req = $bdd->prepare('DELETE FROM articles WHERE id_article = ?');
        $req->execute(array($id));
        header("Location: admin.php");
    }
}

function verifier($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function rechercheArticle($id)
{
    require '../src/bdd.php';
    $req = $bdd->prepare("SELECT * FROM articles WHERE id_article = ?");
    $req->execute(array($id));
    return $req->fetch();
}

function validationImage($image) {
    $imagePath = '../public/assets/img_article/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $maxFileSize = 1000000; 
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    // Pas de nouvelle image
    if (empty($image)) {
        return null; 
    }
    if (!in_array($imageExtension, $allowedExtensions)) {
        return "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
    }
    if (file_exists($imagePath)) {
        return "Le fichier existe déjà";
    }
    if ($_FILES["image"]["size"] > $maxFileSize) {
        return "Le fichier ne doit pas dépasser 1 Mo";
    }
    return $imagePath;
}


function nettoyerCommentaire($commentaire)
{
    return strip_tags($commentaire);
}