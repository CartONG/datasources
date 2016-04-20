<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if (isset($_GET["id"]))
	removeProvider($_GET["id"]);

header('Location: ../controllers/search.php');