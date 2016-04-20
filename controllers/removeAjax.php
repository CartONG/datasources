<?php
include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if ($_POST["name"] == "sp")
		return (removeSp($_POST["id"]));
	if ($_POST["name"] == "e")
		return (removeEchelle($_POST["id"]));
	if ($_POST["name"] == "t")
		return (removeTheme($_POST["id"]));
}
else
	return (false);