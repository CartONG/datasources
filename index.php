<?php

//phpinfo();

include_once('models/connect_bdd.php');

session_start();

if (!isset($_SESSION["id"]))
{
    include_once('views/connection.php');
}
else
	header('Location: ../views/homepage.php');
