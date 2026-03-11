<?php
session_start();
session_destroy(); // Détruire la session

// Rediriger vers une page de déconnexion réussie 
header('Location: base_authentification.html');
exit;
?>