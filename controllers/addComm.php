<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	return (addComm($_POST["value"], $_POST["id_user"], $_POST["id_provider"]));
}