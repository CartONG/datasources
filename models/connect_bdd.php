<?php


$host = "pgsql:host=localhost;dbname=cartOng";
$user = "cartong";
$pwd = "carto20ong00";

try
{
	$bdd = new pdo($host, $user, $pwd);
}
catch (PDOException $e)
{
	echo "La connexion a échoué : " . $e->getMessage();
}
