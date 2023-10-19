<?php
session_start();

$title = "Ajout d'article";

ob_start();

require '../src/bdd.php';
require 'function.php';


$nameError = $descriptionError = $imageError = "";
$name = $description = $image = "";

if (!empty($_POST)) {
    $name = verifier($_POST['name']);
    $description = verifier($_POST['description']);
    $image = verifier($_FILES["image"]["name"]);
    $imagePath = '../public/assets/img_article/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = true;

    if (empty($name)) {
        $nameError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($description)) {
        $descriptionError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($image)) {
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    } else {
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }

        if (file_exists($imagePath)) {
            $imageError = "Le fichier existe déjà";
            $isUploadSuccess = false;
        }

        $maxFileSize = 1000000; 
        if ($_FILES["image"]["size"] > $maxFileSize) {
            $imageError = "Le fichier ne doit pas dépasser 500KB";
            $isUploadSuccess = false;
        }

        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }

    if ($isSuccess && $isUploadSuccess) {
        $req = $bdd->prepare("INSERT INTO articles (name, description, image) VALUES (?, ?, ?)");
        $req->execute(array($name, $description, $image));
        header("Location: admin.php");
    }
}
?>

<div class="container flexColumn gap-5 w-100 border">
    <h1 class="text-center my-5"><strong>AJOUTER UN ARTICLE</strong></h1>
    <hr class="w-50">
    <form class="container flexCenter mt-5 w-75 text-center" action="ajouter.php" role="form" method="post" enctype="multipart/form-data">
        <label for="name">Titre de l'article:</label>
        <input type="text" class="form-control w-50 my-5" id="name" name="name" placeholder="Titre article" value="<?php echo $name; ?>">
        <span class="help-inline"><?php echo $nameError; ?></span>
        <label for="description">Contenu article:</label>
        <textarea class="form-control my-5" name="description" id="description" cols="30" rows="10" placeholder="Contenu article" value="<?php echo $description; ?>"></textarea>
       
        <span class="help-inline"><?php echo $descriptionError; ?></span>
        <div class="mx-auto d-block text-center flexColumn pt-5 w-75">
            <label for="image">Sélectionner une nouvelle image:</label>
            <br>
            <input class="form-control" type="file" id="image" name="image">
            <span><?php echo $imageError; ?></span>
        </div>
        <div class="form-actions flexRow pb-5">
            <button type="submit" class="btn btn-success btn-lg"> Ajouter</button>
            <button class="btn btn-persoBlue btn-lg"><a href="admin.php"> Retour</a></button>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
require('../view/baseAdmin.php');
?>
