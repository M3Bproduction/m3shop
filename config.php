<?php
// Configuration des paramètres
$host = 'localhost';
$db = 'istae_gestion';
$user = 'root'; //Par défaut sous WAMP/XAMPP
$pass = ''; // Par défaut vide sous WAMP/XAMPP
$charset = 'utf8mb4';

//Option PDO pour sécurité et le débogage
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

$dns = "mysql:host=$host;dbname=$db;charset=$charset";

try {
	$pdo = new PDO($dns, $user, $pass, $options);
	//Si tu vois ce message, la connexion fonctionne
	// echo "Connexion réusie !";
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>