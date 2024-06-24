<?php
namespace App;

session_start();

require_once "Autoloader.php";
Autoloader::register();

use App\Db\Db;


// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = Db::getInstance();
    
    // transaction
    $db->beginTransaction();
    
    try {
        // Supprime les enregistrements associés dans la table status
        $sql = "DELETE FROM status WHERE user_id = ?";
        $query = $db->prepare($sql);
        $query->execute([$user_id]);
        
         // Supprime les enregistrements associés dans la table comments
         $sql = "DELETE FROM comments WHERE id = ?";
         $query = $db->prepare($sql);
         $query->execute([$user_id]);

          // Supprime les enregistrements associés dans la table messages
        $sql = "DELETE FROM messages WHERE pseudo = ?";
        $query = $db->prepare($sql);
        $query->execute([$user_id]);
        
        // Supprime l'utilisateur de la table users
        $sql = "DELETE FROM users WHERE id = ?";
        $query = $db->prepare($sql);
        $query->execute([$user_id]);

        // Valide la transaction
        $db->commit();
        
        // Détruit la session et rediriger vers la page d'accueil
        session_destroy();
        header("Location: index.php");
        exit();
    } catch (\Exception $e) {
        // Annule la transaction en cas d'erreur
        $db->rollBack();
        $error = "Une erreur est survenue lors de la désinscription : " . $e->getMessage();
    }
}

$title = "désinscription";
include_once "includes/header.php";
?>
<div class="wrapper">
<main> 
    <section class="desinscription">
        <h3>Se désinscrire</h3>
        <div class="unsubscribe">
            <?php if ($error): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <p>Êtes-vous sûr de vouloir vous désinscrire ?</p>
            <p>Cette action est irréversible.</p>
            <form action="desinscription.php" method="post">
                <div class="submit">
                    <button class="btn mt-3 mb-4" type="submit">Confirmer</button>
                    <a href="profil.php" class="btn mt-3 mb-4">Annuler</a>
                </div>
            </form>
        </div>
    </section>
</main>
</div>


<?php include_once "includes/footer.php"; ?>