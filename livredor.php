<?php
namespace App;

session_start();

use App\Models\MessagesModel;

require_once "Autoloader.php";
Autoloader::register();


if ((!empty($_POST))) {
    if (
        isset($_POST["pseudo"], ($_POST["message"])) && !empty($_POST["pseudo"]) && !empty($_POST["message"])
    ) {
        /**
         * Protection des données contre les injections XSS
         */
        $pseudo = htmlspecialchars($_POST["pseudo"]);
        $note = htmlspecialchars($_POST["message"]);
        $created_at = date("Y-m-d H:i:s");

        if (
            isset($_SESSION["user"])

        ) {
            $guestbook = new MessagesModel;
            $donnees = ($_POST);
            $guestbook->setPseudo($pseudo)
                ->setNote($note)
                ->setCreatedAt($created_at);
            $guestbook->create();

        } else {
            $_SESSION['erreur'] = ("Vous devez être connecté avant d'envoyer un message");
            header('Location: auth.php');
            exit;
        }
    }
}

$title = "Livre d'or";
include_once "includes/header.php";
?>

<section class="lo">
    <h3>Livre d'Or</h3>


    <form action="" method="post">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="message">Votre message</label>
            <textarea rows="15" cols="40" class="form-control" id="message" name="message" placeholder="Ecrivez votre message ici max.350 caractères" onkeyup="textLimit(this, 350);" required></textarea>
        </div>
        <div class="submit">
            <button class="or" class="btn mt-3 mb-4" type="submit"> Envoyer</button>
        </div>
    </form>
    <div class="container">
    <?php $messagesModel = new MessagesModel();
          $messages = $messagesModel->getAllMessages();
        if (isset($messages)): ?>
            <h2 class="mb-4">Vos messages :</h2>
            <?php foreach ($messages as $message) : ?>
                <?= $message->toHTML() ?>
            <?php endforeach; ?>
            <?php unset($messages); ?>
        <?php endif; ?>
    </div>
</section>


<?php
include_once "includes/footer.php";
?>