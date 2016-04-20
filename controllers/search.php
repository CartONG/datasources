<?php

include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

$result = getAllProviders();

$thPro = getProviderThematique();

$them = getAllThematique();

$echelle = getAllEchelle();

$sp = getAllSystemeProjection();

include_once("../views/search.php");