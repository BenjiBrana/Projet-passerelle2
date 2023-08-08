<?php

session_start();


$title = "Modifier article";

ob_start();

require '../src/bdd.php';


if (!empty($_GET['id'])) {
    $id = ($_GET['id']);
}

$nameError = $descriptionError = $imageError = $name = $description = $image = "";

if (!empty($_POST)) {
    $name               = ($_POST['name']);
    $description        = ($_POST['description']);
    $image              = ($_FILES["image"]["name"]);
    $imagePath          = '../public/assets/img_article/' . basename($image);
    $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
    $success          = true;

    if (empty($name)) {
        $nameError = 'Ce champ ne peut pas être vide';
        $success = false;
    }
    if (empty($description)) {
        $descriptionError = 'Ce champ ne peut pas être vide';
        $success = false;
    }

    if (empty($image)) // 
    {
        $ImageUpdate = false;
    } else {
        $ImageUpdate = true;
        $updateSuccess = true;
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            $updateSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "Le fichier existe deja";
            $updateSuccess = false;
        }
        if ($_FILES["image"]["size"] > 1000000) {
            $imageError = "Le fichier ne doit pas depasser les 1MO";
            $updateSuccess = false;
        }
        if ($updateSuccess) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $updateSuccess = false;
            }
        }
    }

    if (($success && $ImageUpdate && $updateSuccess) || ($success && !$ImageUpdate)) {


        $req = $bdd->prepare("UPDATE articles  set name = ?, description = ?, image = ? WHERE id_article = ?");
        $req->execute(array($name, $description, $image, $id));


        header("Location: admin.php");
    } else if ($ImageUpdate && !$updateSuccess) {

        $req = $bdd->prepare("SELECT * FROM articles where id_article = ?");
        $req->execute(array($id));
        $article = $req->fetch();
        $image          = $article['image'];
    }
} else {

    $req = $bdd->prepare("SELECT * FROM articles where id_article = ?");
    $req->execute(array($id));
    $article = $req->fetch();
    $name           = $article['name'];
    $description    = $article['description'];
    $image          = $article['image'];
}
?>
<div class="container my-5">
    <h1 class="text-center my-5"><strong>MODIFIER L'ARTICLE</strong></h1>
    <div class="flexColumn w-100">
        <div class="card flex w-100 p-3 text-center">
            <div class="my-4">
                <label class="mb-5"> Image:</label>
                <img class="card-img-top mx-auto d-block border border-dark" src="<?php echo '../public/assets/img_article/' . $article['image']; ?>" alt="Image article">
            </div>
            <div class="my-4">
                <label> Titre:</label>
                <div class="flexColumn border mt-5 p-3 w-50 mx-auto">
                    <?php echo '  ' . $article['name']; ?>
                </div>
            </div>
            <div class="my-4">
                <label>Contenu:</label>
                <div class="flexColumn border mt-5 p-3 w-75 mx-auto">
                    <?php echo '  ' . $article['description']; ?>
                </div>
            </div>
            <hr class="w-50 mx-auto my-5">
            <form class="container flexCenter mt-5 w-75 text-center" action="<?php echo 'update.php?id=' . $id; ?>" role="form" method="post" enctype="multipart/form-data">
                <label for="name">Titre de l'article:</label>
                <input type="text" class="form-control w-75 my-5" id="name" name="name" placeholder="Titre article" value="<?php echo $name; ?>">
                <span class="help-inline"><?php echo $nameError; ?></span>
                <label for="description">Contenu article:</label>
                <textarea class="form-control my-5" name="description" id="description" cols="30" rows="10" placeholder="Contenu article" value="<?php echo $description; ?>"></textarea>
                
                <span class="help-inline"><?php echo $descriptionError; ?></span>
                <div class="flexColumn  text-center  pt-5 w-75">
                    <label class="mb-5" for="image">Sélectionner une nouvelle image:</label>
                    <input class="form-control w-75 my-5" type="file" id="image" name="image">
                    <span><?php echo $imageError; ?></span>
                </div>
                <div class="form-actions flexRow align-items-stretch pb-5">
                    <button type="submit" class="btn btn-success btn-lg"> Modifier</button>
                    <button class="btn btn-persoBlue btn-lg"><a href="admin.php"> Retour</a></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('../view/baseAdmin.php');
?>