<?php
session_start();
require_once('../src/bdd.php');
require_once('../src/parametre.php');

$title = "Article";
ob_start();


function verifier($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $articleId = $_GET['id'];
    $commentaireArticleId = $_GET['id'];



    $req = $bdd->prepare('SELECT * FROM articles WHERE id_article = ?');
    $req->execute(array($articleId));

    if ($req->rowCount() > 0) {

        $articleDonnees = $req->fetch();
        $id_article             = verifier($articleDonnees['id_article']);
        $name_article           = verifier($articleDonnees['name']);
        $description_article    = verifier($articleDonnees['description']);
        $image_article           = verifier($articleDonnees['image']);
    } else {
        $errorMsg = "Aucun article n'a été trouvée";
    }

    if (isset($_POST['publier'])) {

        if (!empty($_POST['commentaire'])) {


            $commentaire            = verifier($_POST['commentaire']);
            $pseudo_commentaire     = verifier($_SESSION['first_name']) . ' ' . verifier($_SESSION['last_name']);
            $id_article             = verifier($_GET['id']);
            $req = $bdd->prepare("INSERT INTO commentaires (pseudo_commentaire,commentaire,id_article) values(?,?,?)");
            $req->execute(array($pseudo_commentaire, $commentaire, $id_article));
        }
    }


    $req = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id_commentaire ');
    $req->execute(array($commentaireArticleId));
    if ($req->rowCount() > 0) {
    } else {
        $errorMsg = "Aucun commantaire";
    }
} else {
    $errorMsg = "Aucun article n'a été trouvée";
}


?>
<div class="container">
    <h2>Blog</h2>
    <div class="flexColumn gap-5">
        <div class="card flex w-75">
            <img class="card-img-top mx-auto d-block border border-dark" src="<?php echo '../public/assets/img_article/' . $image_article; ?>" alt="Image article">
            <div class="card-body p-5 flexCenter">
                <h2 class="text-center mt-5"><?= $name_article ?></strong>
                </h2>
                <p class="card-text w-75 mb-auto"><?= $description_article ?>.</p>
            </div>
        </div>

        <div class="container w-75 ">
            <h3>Commentaire:</h3>
            <div class="container ">
                <?php
                if (isset($errorMsg)) {
                    echo $errorMsg;
                }
                while ($usersInfos = $req->fetch()) {
                    $commentaire_pseudo = $usersInfos['pseudo_commentaire'];
                    $commentaire_contenu = $usersInfos['commentaire'];
                    $date_commentaire = $usersInfos['date_publication'];
                    $commentaire_id_article = $usersInfos['id_article'];
                ?>
                    <div class="card">
                        <div class="card-header flexRow justify-content-between p-3">
                            <span> <?= $usersInfos["pseudo_commentaire"] . '</span> <span>' .  $usersInfos["date_publication"]; ?> </span>
                        </div>
                        <div class="card-body">
                            <p class="p-3"> <?= $usersInfos["commentaire"]; ?> </p>
                        </div>
                    </div>
                    <br>
                <?php
                }
                ?>
            </div>
            <form class="container flexCenter mt-5 w-75 text-center" role="form" method="post" enctype="multipart/form-data">
                <textarea class="form-control my-5 mx-auto" name="commentaire" id="commentaire" cols="30" rows="10" placeholder="Commente ici" value="Commente ici "></textarea>

                <div class="form-actions flexRow pb-5">
                    <button type="submit" name="publier" class="btn btn-success btn-lg"> Publier</button>
                    <button class="btn btn-persoBlue btn-lg"><a href="blog.php"> Retour</a></button>
                </div>
            </form>
        </div>
        <hr>
        <?php

        ?>
    </div>
</div>
<?php 


$content = ob_get_clean();
require('base.php');
?>