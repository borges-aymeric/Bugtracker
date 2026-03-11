<?php
session_start(); // Démarrage de la session
if (!isset($_SESSION['connexion'])) // Vérification de l'authentification
{
	header('Location: base_authentification.html'); // Redirection vers le formulaire d'authentification
	exit;
}

try {
	$db = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
	echo "Erreur :" . $e->getMessage();
}
$tickets = null;
$devs = null;

$title = "";
if ($_SESSION['statut'] == 2) { //connexion statut 2 (tes)
	$title = "TESTEUR";
	$sqlticket = "SELECT * FROM sae203_ticket WHERE user_id = :user_id";
	$requeteticket = $db->prepare($sqlticket);
	$requeteticket->execute(['user_id' => $_SESSION['user_id']]);
	$tickets = $requeteticket->fetchAll();
}
if ($_SESSION['statut'] == 1) {
	$title = "DEV";
	$sqlticket = "SELECT * FROM sae203_ticket WHERE user_assign = :user_id";
	$requeteticket = $db->prepare($sqlticket);
	$requeteticket->execute(['user_id' => $_SESSION['user_id']]);
	$tickets = $requeteticket->fetchAll();
}
if ($_SESSION['statut'] == 0) {
	$title = "ADMIN";

	$sqlticket = "SELECT * FROM sae203_ticket ";
	$requeteticket = $db->prepare($sqlticket);
	$requeteticket->execute();
	$tickets = $requeteticket->fetchAll();

	$sqldev = "SELECT * FROM sae203_user WHERE statut = 1";
	$requetedev = $db->prepare($sqldev);
	$requetedev->execute();
	$devs = $requetedev->fetchAll();

}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?= $title ?>
	</title><!--short echo tags-->
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 20px;
		}

		h1 {
			text-align: center;
		}

		hr {
			margin-top: 20px;
			margin-bottom: 20px;
			border: 0;
			border-top: 1px solid #ccc;
		}

		a {
			text-decoration: none;
			color: #007bff;
		}

		fieldset {
			margin-bottom: 20px;
			padding: 20px;
			border: 1px solid #ccc;
		}

		form p {
			margin-bottom: 10px;
		}

		label {
			display: block;
			margin-bottom: 5px;
		}

		select,
		textarea {
			width: 100%;
			padding: 5px;
			border: 1px solid #ccc;
		}

		button {
			padding: 5px 10px;
			background-color: #007bff;
			color: #fff;
			border: none;
			cursor: pointer;
		}

		th,
		td {
			border: 1px solid #ccc;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f0f0f0;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<h1>
		<?= $title ?>
	</h1><!--short echo tags-->


	<hr>
	<a href="deconnexion.php">Se déconnecter</a>

	<br><br><br>
	<?php
	if ($_SESSION["statut"] == 2) { ?> <!-- si statut 2 (testeur), afficher le formulaire de ticket-->
		<fieldset>
			<legend>Formulaire ticket</legend>

			<form method="post" action="ticketadd.php">

				<p>
					<label for="title"> Titre du bug: </label>
					<input type="text" name="title" id="title" required>
				</p>
				<p>
					<label for="tag">Tag :</label><br>
					<select id="tag" name="tag">
						<option value="probleme_fonctionnalite">Problème de fonctionnalité</option>
						<option value="bug_graphisme">Bug Graphisme</option>
						<option value="crash">Crash</option>
						<option value="autre">Autre</option>
					</select><br>
				</p>
				<p>
					<label for="description" style="display: block; margin-bottom: 5px;"> Description du bug : </label>
					<textarea id="description" name="description" rows="4" cols="50" style="resize: none;"
						required></textarea>
					<br>
				</p>
				<p>
					<input type="submit" value="ENVOYER">
				</p>

			</form>

		</fieldset>
	<?php } ?>

	<table style='border-collapse: collapse;'> <!--En tête du tableau pour tout les rôle-->
		<tr>
			<th style='border: 1px solid black;'>ID ticket</th>
			<th style='border: 1px solid black;'>ID user</th>
			<th style='border: 1px solid black;'>Date bug</th>
			<th style='border: 1px solid black;'>Titre</th>
			<th style='border: 1px solid black;'>Tag</th>
			<th style='border: 1px solid black;'>Description</th>
			<th style='border: 1px solid black;'>Priorité</th>
			<th style='border: 1px solid black;'>Statut</th>
			<th style='border: 1px solid black;'>Developpeur</th>
		</tr>
		<?php
		foreach ($tickets as $ticket) {
			$id = $ticket['id'];
			$title = $ticket['title'];
			$tag = $ticket['tag'];
			$description = $ticket['description'];
			$date = $ticket['date_create'];
			$statut = $ticket['statut'];
			$user_id = $ticket['user_id'];
			$priority = $ticket['priority'];
			$developper = $ticket['user_assign'];
			if ($_SESSION['statut'] == 1 || $_SESSION['statut'] == 0) { //si statut 0 (admin) ou statut 1 (testeur) , afficher modif statut
				$vals = array("Résolu", "En cours de traitement", "Rejeté", "Vérification", "Non Bloquant");
				$options = "";
				foreach ($vals as $val) {
					if ($val == $ticket['statut']) {
						$options .= "<option selected='true' value='{$val}'>{$val}</option>";
					} else {
						$options .= "<option value='{$val}'>{$val}</option>";
					}

				}
				$statut = "<form action='statut.php' method='POST'>
				<input type='hidden' name='ticket_id' value='$id' style='display:none;'>
					<select name='statut'>
					{$options}
					</select>
					<button type='submit'>Assigner</button>
				</form>";
			}

			if ($_SESSION['statut'] == 0) { //si statut 0 (admin), afficher modif priorité et assignement des dev
				$vals = array(0, 1, 2, 3, 4, 5);
				$options = "";
				foreach ($vals as $val) {
					if ($val == $ticket['priority']) {
						$options .= "<option selected='true' value='{$val}'>{$val}</option>";
					} else {
						$options .= "<option value='{$val}'>{$val}</option>";
					}

				}
				$priority = "<form action='priority.php' method='POST'>
				<input type='hidden' name='ticket_id' value='$id' style='display:none;'>
					<select name='priority'>
					{$options}
					</select>
					<button type='submit'>Assigner</button>
				</form>";

				$formdev = "<option value='' selected='true' default disabled ></option>";
				foreach ($devs as $dev) {
					$dev_id = $dev['id'];
					$dev_login = $dev['login'];
					if ($dev['id'] == $ticket['user_assign']) {
						$formdev .= "<option selected='true' value='$dev_id'>$dev_login</option>";
					} else {
						$formdev .= "<option value='$dev_id'>$dev_login</option>";
					}

				}
				$id_ticket = $ticket['id'];
				$developper = "<form action='developper.php' method='POST'>
				<input type='hidden' name='ticket_id' value='$id_ticket' style='display:none;'>
					<select name='user_assign'>
				  {$formdev}
				  </select>
				  <button type='submit'>Assigner</button>
				</form>";
			}


			// Ajouter une ligne dans le tableau avec les données du ticket pour tout les 
			echo "<tr>
              <td style='border: 1px solid black;'>{$id}</td>
              <td style='border: 1px solid black;'>{$user_id}</td>
              <td style='border: 1px solid black;'>{$date}</td>           
              <td style='border: 1px solid black;'>{$title}</td>
              <td style='border: 1px solid black;'>{$tag}</td>
              <td style='border: 1px solid black;'>{$description}</td>
			  <td style='border: 1px solid black;'>{$priority}</td>
			  <td style='border: 1px solid black;'>{$statut}</td>
			  <td style='border: 1px solid black;'>{$developper}</td> 
		
            </tr>";

		}
		?>
</body>

</html>