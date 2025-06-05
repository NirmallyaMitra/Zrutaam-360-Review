<?php
$host = 'localhost';
$db = 'zrutaam2';
$user = 'root';
$pass = 'Zrutaam@7007';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("DB connection failed: " . $e->getMessage());
}
