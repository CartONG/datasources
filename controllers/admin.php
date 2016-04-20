<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

session_start();

if ($_SESSION["admin"] == true)
{
	$user = getAllUsers();

	$theme = getAllThematique();

	$sp = getAllSystemeProjection();

	$echelle = getAllEchelle();

	include_once("../views/admin.php");
}
else
	header('Location: ../index.php');