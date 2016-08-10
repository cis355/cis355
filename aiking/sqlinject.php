<?php
$name = $_POST['name']; // field allows SQL injection
$name2 = $_POST['name2']; // field protects against it
require ('crud/database.php');
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "INSERT INTO customers (name) VALUES ('$name')";
$q = $pdo->prepare($sql);
$q->execute();

$sql = "INSERT INTO customers (name) VALUES (?)";
$q = $pdo->prepare($sql);
$q->execute(array($name2));

Database::disconnect();

/* hackstring is middle line below
INSERT INTO customers (name) VALUES ('$name
Zippydee'); INSERT INTO customers (name) VALUES ('George
')
*/

show_source(__FILE__);




















?>