<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

session_start();

if ($_SESSION["admin"] == true && isset($_POST['id']))
{
	$id = $_POST['id'];

	if (removeUser($id) == true)
	{
		return true;
	}
	else
		return false;
}
else
	return false;