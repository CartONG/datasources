<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");



$id = $_GET["id"];



if (isset($id))
{
	$res = getProviderFromId($id);
	$t = getNameThematiqueFromIdProvider($_GET["id"]);
	$res["theme"] = $t;
	$comm = getAllCommFromProviderId($id);
	include_once("../views/detail.php");
}
else
	include_once("../index.php");