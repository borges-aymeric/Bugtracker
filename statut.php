<?php

// recup donnee du formulaire
$ticketId = $_POST['ticket_id'];
$statutticket = $_POST['statut'];

try {
    $db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sqlstatut = "UPDATE sae203_ticket SET statut = :statut WHERE id = :id";
    $requetestatut = $db->prepare($sqlstatut);
    $requetestatut->execute([':statut' => $statutticket, ':id' => $ticketId]);

    echo "Le ticket $ticketId est maintenant $statutticket.";

    // Rediriger l'administrateur vers une page de confirmation ou une autre page pertinente
} catch (Exception $e) {
    echo "Erreur :" . $e->getMessage();
}
include('tickets.php');
?>