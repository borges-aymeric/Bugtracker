<?php
session_start(); // Démarrage de la session
if (!isset($_SESSION['connexion'])) // Vérification de l'authentification
{
    header('Location: base_authentification.html'); // Redirection vers le formulaire d'authentification
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$tag = $_POST['tag'];
$statut = 'Vérification';

try {
    $db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sqlticket = "INSERT INTO sae203_ticket (title, description, tag ,user_id, statut) VALUES (:title, :description, :tag, :user_id, :statut)";
    $requeteticket = $db->prepare($sqlticket);
    $requeteticket->execute(['title' => $title, 'description' => $description, 'tag' => $tag, 'user_id' => $_SESSION['user_id'], 'statut' => $statut]);

    echo "Ticket crée et envoyé !<br><br>";
    echo '<a href="tickets.php">Formuler un nouveau ticket?</a><br><br>';
    echo '<a href="deconnexion.php">Déconnexion?</a>';
} catch (Exception $e) {
    echo "Erreur :" . $e->getMessage();
}

?>