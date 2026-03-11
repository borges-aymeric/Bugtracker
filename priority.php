<?php

// recup donnee du formulaire
$ticketId = $_POST['ticket_id'];
$prioticket = $_POST['priority'];

try {
    $db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sqlpriority = "UPDATE sae203_ticket SET priority = :priority WHERE id = :id";
    $requetepriority = $db->prepare($sqlpriority);
    $requetepriority->execute([':priority' => $prioticket, ':id' => $ticketId]);

    echo "Le ticket $ticketId est maintenant en priorité $prioticket.";

    // Rediriger l'administrateur vers une page de confirmation ou une autre page pertinente
} catch (Exception $e) {
    echo "Erreur :" . $e->getMessage();
}
include('tickets.php');
?>