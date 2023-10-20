<?php
session_start();
require_once('../src/bdd.php');
require_once('../src/parametre.php');
require('../admin/function.php');
$title = "Blog";
ob_start();
?>

<div class="container">
    <h2>Blog</h2>
    <div class="flexColumn gap-5">

        <?php
        $req = $bdd->query('SELECT * FROM articles ORDER BY id_article DESC');
        while ($article = $req->fetch()) {
            $articleId = $article['id_article'];
            // Compteur de commentaires
            $nombreCommentaire = 0; 
            // Requête SQL pour compter les commentaires
            $com = $bdd->prepare('SELECT COUNT(*) AS count FROM commentaires WHERE id_article = :articleId');
            $com->bindParam(':articleId', $articleId, PDO::PARAM_INT);
            $com->execute();
            // Récupération du nombre de commentaires
            $totalCommentaire = $com->fetch();
            if ($totalCommentaire) {
                $nombreCommentaire = $totalCommentaire['count'];
            }
        ?>

            <div class="card flex">
                <a href="article.php?id=<?= $article['id_article']; ?>">
                    <img class="card-img-top mx-auto d-block border" src="<?php echo '../public/assets/img_article/' . $article['image']; ?>" alt="Image article">
                    <div class="card-body p-5 flexCenter">
                        <h2 class="text-center mt-5"><?= $article['name'] ?></strong>
                        </h2>
                        <p class="card-text w-75 mb-auto"><?= $article['description'] ?>.</p>
                    </div>
                </a>
                <div class="commentaire">
                    <p class="nombreCommentaire">
                        <?= $nombreCommentaire ?>
                    </p>
                </div>
            </div>
            <hr>
        <?php
        }
        ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require('base.php');
?>