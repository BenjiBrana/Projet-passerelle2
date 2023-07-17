<?php
session_start();
require_once('../src/parametre.php');

$title = "Blog";
ob_start();

require_once('../src/bdd.php');
function verifier($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div class="container">

    <h2>Blog</h2>

    <div class="flexColumn gap-5">
        <?php
        $req = $bdd->query('SELECT * FROM articles ORDER BY id_article DESC');
        while ($article = $req->fetch()) {
        ?>
            <div class="card flex">
                <a href="article.php?id=<?= $article['id_article']; ?>">
                    <img class="card-img-top mx-auto d-block border border-dark" src="<?php echo '../public/assets/img_article/' . $article['image']; ?>" alt="Image article">
                    <div class="card-body p-5 flexCenter">
                        <h2 class="text-center mt-5"><?= $article['name'] ?></strong>
                        </h2>
                        <p class="card-text w-75 mb-auto"><?= $article['description'] ?>.</p>
                    </div>
                </a>
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