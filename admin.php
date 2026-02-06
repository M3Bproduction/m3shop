<?php
require_once 'config.php';

// Requête avec JOINTURE pour lier Etudiant, Inscription, Filière et Paiement
$sql = "SELECT E.nom_etd, E.pre_etd, I.id_ins, I.niveau, I.statut_ins, F.libelle_filiere, P.preuve_img
	FROM ETUDIANT E
	JOIN INSCRIPTION I ON E.id_etd = I.id_etd
	JOIN FILIERE F ON I.id_filiere = F.id_filiere
	LEFT JOIN PAIEMENT P ON I.id_ins = P.id_ins
	ORDER BY I.date_ins DESC";

$stmt = $pdo->query($sql);
$inscriptions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Administration ISTAE</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<nav class="navbar navbar-dark bg-dark mb-4">
		<div class="container">
			<span class="navbar-brand">Espace Secrétariat - ISTAE</span>
		</div>
	</nav>

	<div class="container">
		<h3 class="mb-4">Liste des nouvelles inscriptions</h3>

		<div class="table-responsive bg-white p-3 shadow-sm rounded">
			<table class="table table-hover align-middle">
				<thead class="table-light">
					<tr>
						<th>Etudiant</th>
						<th>Filière / Niveau</th>
						<th>Preuve Paiement</th>
						<th>Statut</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($inscriptions as $i): ?>
					<tr>
						<td><strong><?=strtoupper($i['nom_etd']) ?></strong> <?= $i['pre_etd'] ?></td>
						<td><?=$i['libelle_filiere'] ?><br><small class="text-muted"><?= $i['niveau'] ?></small></td>
						<td>
							<?php if($i['preuve_img']): ?>
							<a href="<? = $i['preuve_img'] ?>" target="_blank" class="btn btn-sm btn-outline-info">Voir le reçu</a>
							<?php else: ?>
							<span class="badge bg-warning text-dark">Pas de fichier</span>
							<?php endif; ?>
						</td>
						<td>
							<span class="badge <?= ($i['statut_ins'] == 'Validé') ? 'bg-success' : 'bg-secondary' ?>"><?= $i['statut_ins'] ?></span>
						</td>
						<td>
							<a href="statut.php?id=<?= $i['id_ins'] ?>&action=valider" class="btn btn-sm btn-success" onclick="return confirm('Valider cette inscription ?')">Valider</a>
							<a href="statut.php?id=<?= $i['id_ins'] ?>&action=rejeter" class="btn btn-sm btn-danger" onclick="return confirm('Rejeter ce dossier ?')">Rejeter</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>