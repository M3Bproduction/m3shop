<?php
require_once 'config.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
	$id = $_GET['id'];
	$action = $_GET['action'];

	// Déterminer le nouveau statut
	$nouveauStatut = ($action == 'valider') ? 'Validé' : 'Rejeté';

	try {
		// Requête de mise à jour
		$sql = "UPDATE INSCRIPTION SET statut_ins = ? WHERE id_ins = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$nouveauStatut, $id]);

		// Redirection vers la page admin après modification
		header("Location: admin.php? msg=Statut mis à jour");
		exit();
	} catch (PDOException $e) {
		die("Erreur lors de la mise à jour : " . $e->getMessage());
	}
} else {
	header("Location: admin.php");
}
?>