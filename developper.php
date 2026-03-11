<?php

// recup donnee du formulaire
$ticketId = $_POST['ticket_id'];
$devId = $_POST['user_assign'];

try {
    $db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sqlassigndev = "UPDATE sae203_ticket SET user_assign = :user_assign WHERE id = :id";
    $requetedevassign = $db->prepare($sqlassigndev);
    $requetedevassign->execute([':user_assign' => $devId, ':id' => $ticketId]);

    echo "Le ticket $ticketId a été assigné au développeur $devId.";

    // Rediriger l'administrateur vers une page de confirmation ou une autre page pertinente

} catch (Exception $e) {
    echo "Erreur :" . $e->getMessage();
}
include('tickets.php');
?>