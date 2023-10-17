<?php
require_once('../src/bdd.php');
require_once('../src/parametre.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?> | ARCC</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../public/design/css/default.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../public/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="../public/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Ajout de TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/eerzdp30ehig6yl7bqqz0yp0mmveajbvuw72h8pz9u7fwvrq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#commentaire',
            plugins: "  searchreplace autolink directionality  visualblocks visualchars image link media  codesample table charmap pagebreak nonbreaking anchor  insertdatetime advlist lists  wordcount   help   charmap  emoticons   autosave",
            toolbar: "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat",
        });

        function tinyTextarea() {
            tinyMCE.get('commentaire').getContent({
                format: 'html'
            });
        }
    </script>
</head>

<body class="bg-primary text-dark">
    <header class="header flexCenter w-100 mx-0">
        <?php if (isset($_SESSION['connect'])) {
        ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="btnMenu">
                    <button class="burger" type="button">
                        <span class="bar"></span>
                    </button>
                </div>
                <div class="navbarTitle pt-5">
                    <h1 class="text-center"> <b>A</b>chat <b>R</b>entable <b>C</b>arte <b>C</b>adeau</h1>
                </div>
                <div class="navbarLogo">
                    <img class="logo" src="../public/assets/img/Logo.png" alt="Logo">
                </div>
                <div class="navbar-nav">
                    <ul class="navbar-items me-auto mb-2 mb-lg-0 p-0">
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">Blog</a>
                        </li>
                        <?php
                        $req = $bdd->query('SELECT * FROM users ');
                        while ($admin = $req->fetch()) {
                            if ($_SESSION['type'] == 'admin') {
                        ?>
                                <li class="nav-item active" aria-current="page">
                                    <a class="nav-link" href="../admin/admin.php">Dashboard</a>
                                </li>
                        <?php  }
                            break;
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                        </li>
                    </ul>

                </div>

            </nav>
        <?php }

        ?>


    </header>
    <section class="container my-3 flexColumn">

        <?= $content ?>

    </section>

    <footer class="footer mt-auto py-3 ">
        <div class="container">
            <p>A.R.C.C | &copy; <?php echo date('Y') ?> </p>

        </div>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="../public/script/menu.js"></script>

</body>

</html>