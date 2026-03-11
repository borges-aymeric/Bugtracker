<?php


// Connexion à la base de données.   
try {
    $db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('Erreur :' . $e->getMessage());
}
session_start();
// Vérifier si les informations d'identification ont été soumises
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = sha1($_POST['password']);

    // requete sql
    $sql = "SELECT * FROM sae203_user WHERE login=? AND password=?";
    $requetesql = $db->prepare($sql);
    $requetesql->execute([$login, $password]);
    $user = $requetesql->fetch();

    if (!$user) { // si user est différent
        echo "L'identifiant ou le mot de passe est incorrect. <br>";
        echo '<a href="base_authentification.html">Réessayer?</a>';
        return;
    }

    $_SESSION['connexion'] = true;
    $_SESSION['statut'] = $user['statut'];
    $_SESSION['user_id'] = $user['id'];

    header("Location: tickets.php");
    return;

}

?>
