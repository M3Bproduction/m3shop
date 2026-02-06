<?php
require_once 'config.php'; // On récupère la connexion PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// 1. Récuperation des données du formulaire
	$nom = htmlspecialchars($_POST['nom']);
	$prenom = htmlspecialchars($_POST['prenom']);
	$filiere_id = $_POST['filiere'];
	$niveau = $_POST['niveau'];

	// 2. Gestion de l'upload du reçu de paiement
	$dossier_destination = "uploads/";

	// Créer le dossier s'il n'existe pas
	if (!is_dir($dossier_destination)) {
		mkdir($dossier_destination, 0777, true);
	}

	$nom_fichier = time() . "_" . basename($_FILES["recu"]["name"]);
	$chemin_complet = $dossier_destination . $nom_fichier;
	$upload_ok = move_uploaded_file($_FILES["recu"]["tmp_name"], $chemin_complet);

	if ($upload_ok) {
		try {
			// Début de la transaction (merise : intégrité des données)
			$pdo->beginTransaction();

			// A. Insertion de l'étudiant
			$sqlEtd = "INSERT INTO ETUDIANT (nom_etd, pre_etd) VALUES (?, ?)";
			$stmtEtd = $pdo->prepare($sqlEtd);
			$stmtEtd->execute([$nom, $prenom]);
			$id_etudiant = $pdo->lastInsertId();

			// B. Insertion de l'inscription
			$sqlIns = "INSERT INTO INSCRIPTION (id_etd, id_filiere, niveau) VALUES (?, ?, ?)";
			$stmtIns = $pdo->prepare($sqlIns);

			$stmtIns->execute([$id_etudiant, $filiere_id, $niveau]);
			$id_inscription = $pdo->lastInsertId();

			// C. Insertion du paiement (preuve)
			$sqlPai = "INSERT INTO PAIEMENT (id_ins, preuve_img) VALUES (?, ?)";
			$stmtPai =$pdo->prepare($sqlPai);

			$stmtPai->execute([$id_inscription, $chemin_complet]);

			// Validation de tout le processus
			$pdo->commit();

			echo "<div style='color:green;'>Inscription réussie ! Votre dossier est en cours d'examen par le secrétariat.</div> ";

		} catch (Exception $e) {
			$pdo->rollBack(); // Annule tous en cas d'erreur
			echo "Erreur lors de l'inscription : " . $e->getMessage();
		}
	}else {
		echo "Erreur lors du téléchargement du reçu.";
	}
}
?>