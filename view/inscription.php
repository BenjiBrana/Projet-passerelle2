<?php
session_start();
$title = "Inscription";
require_once('../src/parametre.php');
$errors = [];

if (isset($_SESSION['connect'])) {
    header('location: blog.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (count($errors) === 0) {
        require_once('../src/bdd.php');
        $req = $bdd->prepare('SELECT COUNT(*) as testEmail FROM users WHERE email = ?');
        $req->execute([$email]);
        while ($emailVerification = $req->fetch()) {
            if ($emailVerification['testEmail'] != 0) {
                $errors[] = "Adresse email déjà utilisée.";
            }
        }
    }
    // Chiffrement du mot de passe
    $password = "aq1" . sha1($password . "123") . "25";
    // Code unique
    $code_unique = sha1($email) . time();
    $code_unique = sha1($code_unique) . time();
    if (count($errors) === 0) {
    // Ajouter un utilisateur
    $req = $bdd->prepare('INSERT INTO users(first_name, last_name, email, password, code_unique) VALUES(?, ?, ?, ?, ?)');
    $req->execute([$first_name, $last_name, $email, $password, $code_unique]);
    header('location: connexion.php?success=1');
        exit();
    }
}
ob_start();
?>

<section class="container flexCenter">
    <div class="card-systeme border border-dark my-2 mx-auto flexColumn">
        <div class="card-image card-image-inscription">
        </div>
        <h2 class="card-heading text-center">
            Inscription
        </h2>
        <form class="card-form flexColumn p2" method="post" action="inscription.php">
            <div class="input flexColumn">
                <label for="first_name" class="input-label text-center">Votre Prénom</label>
                <input class="input-field" id="first_name" type="text" name="first_name" placeholder="Nicolas" required />
            </div>
            <div class="input flexColumn">
                <label for="last_name" class="input-label text-center">Votre Nom</label>
                <input class="input-field" id="last_name" type="text" name="last_name" placeholder="Salas" required />
            </div>
            <div class="input flexColumn">
                <label for="email" class="input-label text-center">Votre Email</label>
                <input class="input-field" id="email" type="email" name="email" placeholder="exemple@gmail.com" required />
            </div>
            <div class="input flexColumn">
                <label for="password" class="input-label text-center">Mot de passe</label>
                <input class="input-field" id="password" type="password" name="password" placeholder="Saisir un mot de passe" required />
            </div>
            <div class="input flexColumn">
                <label for="confirm_password" class="input-label text-center">Confirmez le mot de passe</label>
                <input class="input-field" id="confirm_password" type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required />
            </div>
            <?php if (!empty($errors)): ?>
                <div class="alert red mt-5" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="action flexColumn">
                <button type="submit" class="action-button btn btn-lg btn-success p-4">S'inscrire</button>
            </div>
        </form>
        <button class="btn btn-persoBlue btn-lg flexColumn mb-5">
            <a href="../index.php">Retour</a>
        </button>
    </div>
</section>

<?php
$content = ob_get_clean();
require('base.php');
?>