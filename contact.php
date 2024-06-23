<?php
namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

use Dotenv\Dotenv;

$title = "Contact";
include_once "includes/header.php";

set_time_limit(60); 

if (isset($_POST['send'])) {
    if(empty($_POST['mail'])){
        echo "Veuillez noter votre email";
    } elseif (!preg_match("#^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$#i", $_POST['mail'])) {
        echo "L'adresse email est invalide";
    } elseif (empty($_POST['subject'])) { 
        echo "Veuillez remplir le champ objet"; 
    } elseif (empty($_POST['message'])) { 
        echo "Veuillez entrer votre message";  
    } else {
        $mail = new PHPMailer(true);
        // Charge les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/.env', 'contact.env');
        $dotenv->load();

        try {
            // Configure du serveur
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV["MAIL_USERNAME"];
            $mail->Password = $_ENV["MAIL_PASSWORD"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port = $_ENV["MAIL_PORT"];
            

            // Définit l'expéditeur
            $mail->setFrom($_POST['mail'], $_POST['firstname']); 
            $mail->addReplyTo($_POST['mail'], $_POST['firstname']); 
            
            // Destinataire
            $mail->addAddress('lisa@lisawalk.fr'); 

            // Contenu
            $mail->isHTML(true);
            $subject = '=?UTF-8?B?' . base64_encode($_POST['subject']) . '?=';
            $mail->Subject = $subject;
            $mail->Body = nl2br(htmlentities($_POST['message'], ENT_QUOTES, 'UTF-8'));
            $mail->AltBody = htmlentities($_POST['message'], ENT_QUOTES, 'UTF-8');

            $mail->send();
            echo 'Le mail a été envoyé avec succès !';
        } catch (Exception $e) {
            echo "Une erreur est survenue, le mail n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<section class="contact">
    <h3>Besoin d'une information, de précisions ? Je serai ravie de vous répondre</h3>
    <form action="contact.php" method="post">
        <div class="form-group">
            <label for="username">Nom</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subject">Objet</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Votre message</label>
            <textarea rows="15" cols="40" id="message" name="message" class="form-control" required placeholder="Ecrivez votre email ici, 800 caractères maximum"></textarea>
        </div>
        <div class="submit">
            <button class="or btn mt-3 mb-4" type="submit" name="send">Envoyer</button>
        </div>
    </form>
</section>

<?php
include_once "includes/footer.php";
?>
