<?php

include_once("../models/functions_bdd.php");

$all = getAllFromAll($_GET['q']);

$data = json_encode($all);

return ($data);