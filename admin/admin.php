<?php
session_start();
$title = "Admin";
ob_start();
require '../src/bdd.php';
require 'function.php';
supprimer();
?>

<section class="container">
    <h2>Dashboard Admin</h2>
    <hr class="w-50">
    <div class="container mt-5">
        <div class="flexColumn">
            <h1><strong>Liste des articles: </strong>
            </h1>
            <a href="ajouter.php" class="btn btn-success btn-lg my-5 border border-dark ">
                Ajouter un article
            </a>
            <table class="table table-striped  table-bordered text-center">
                <thead>
                    <tr class="titre-tab">
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once('../src/bdd.php');
                    $req = $bdd->query("SELECT * FROM articles ORDER BY id_article DESC");
                    while ($article = $req->fetch()) {
                        echo '<tr class="tab mb-5">
                                <td class="nom">' . $article['name'] . '</td>
                                <td class="description">' . $article['description'] . '</td>
                                <td class="action">
                                    <a class="btn btn-persoBlue btn-lg border m-1" href="view.php?id=' . $article['id_article'] . '"> Voir</a>
                                    <a class="btn btn-warning btn-lg border m-1" href="update.php?id=' . $article['id_article'] . '"> Modifier</a>
                                    <button class="btn btn-danger btn-lg border m-1" data-bs-toggle="modal" data-bs-target="#modalDelete' . $article['id_article'] . '"> Supprimer</button>
                                    <div class="modal fade" id="modalDelete' . $article['id_article'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Suppression article</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Voulez-vous supprimer cet article : ' . $article['name'] . '
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-danger btn-lg" href="admin.php?id=' . $article['id_article'] . '">Oui</a>
                                                    <button type="button" class="btn btn-persoBlue btn-lg" data-bs-dismiss="modal">Non</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>    
                                </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</section>

<?php
$req->closeCursor();

$content = ob_get_clean();

require('../view/baseAdmin.php');
?>