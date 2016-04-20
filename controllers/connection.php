<?php
include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$info = array("login" => $_POST["login"], "password" => $_POST["pass"]);

	if (($res = verifConnection($info)) != false)
	{
		session_start();
		$_SESSION["login"] = $info["login"];
		$_SESSION["id"] = $res["id"];
		$_SESSION["admin"] = $res["admin"];
		header('Location: ../index.php');
	}
	else
	{
		$general_error = "Mauvais identifiant ou mot de passe";
		include_once("../views/connection.php");
	}
}
else
{
	$general_error = "Une erreur s'est produite, veuillez reéssayer";
	include_once("../views/connection.php");
}
