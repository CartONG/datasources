<?php
include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id = $_POST["id"];
	$score = $_POST["score"];
	$res = updateRating($id, $score);
	return ($res);
}
else
	return (false);