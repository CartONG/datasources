<?php
include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$value = $_POST["value"];
	if ($_POST["name"] == "sp")
	{
		$epsg = $_POST["epsg"];
		return (addSp($value, $epsg));
	}
	if ($_POST["name"] == "e")
		return (addEchelle($value));
	if ($_POST["name"] == "t")
		return (addThematique($value));
}
else
	return (false);