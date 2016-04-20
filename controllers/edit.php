<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	if (isset($_GET["id"]))
	{
		$res = getProviderFromId($_GET["id"]);
		$t = getThematiqueFromIdProvider($_GET["id"]);
		$res["theme"] = $t;
	}
	else
		$res = false;
	
	$theme = getAllThematique();
	$echelle = getAllEchelle();
	$sp = getAllSystemeProjection();
	include_once("../views/edit.php");
}



if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id = $_POST["id"];
	$info = array("description" => $_POST["description"], "name" => $_POST["name"], "site" => $_POST["url"], "data_type" => $_POST["data_type"], "echelle" => $_POST["echelle"], "sp" => $_POST["sp"], "theme" => $_POST["theme"]);

	if (isset($id))
		$t = editProvider($info, $id);
	else
		$t = editProvider($info);
	header('Location:../controllers/search.php');
}