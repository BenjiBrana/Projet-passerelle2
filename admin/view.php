<?php
session_start();
$title = "Voir article";
ob_start();

require '../src/bdd.php';
require 'function.php';

if (!empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $article = rechercheArticle($id);
?>
    <div class="container my-5">
        <h1 class="my-5"><strong>VISUALISER L'ARTICLE</strong></h1>
        <div class="flexColumn w-100">
            <div class="card flex w-100 p-3 ">
                <div class="my-4">
                    <label>Image:</label>
                    <img class="card-img-top mx-auto d-block border" src="<?php echo '../public/assets/img_article/' . $article['image']; ?>" alt="Image article">
                </div>
                <div class="my-4">
                    <label> Titre:</label>
                    <div class="flexColumn">
                        <?php echo '  ' . $article['name']; ?>
                    </div>
                </div>
                <div class="my-4">
                    <label>Description:</label>
                    <div class="flexColumn">
                        <?php echo '  ' . $article['description']; ?>
                    </div>
                </div>
                <button class="btn btn-persoBlue btn-lg mx-auto mb-5">
                    <a href="admin.php">Retour</a>
                </button>
            </div>
        </div>
    </div>

<?php
}
$content = ob_get_clean();
require('../view/baseAdmin.php');
?>