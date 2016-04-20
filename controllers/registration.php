
<?php
include_once('../models/connect_bdd.php');
include_once("../models/functions_bdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

	if (isset($_POST["login"]) && isset($_POST["mail"]) && isset($_POST["pass"]) && isset($_POST["conf_pass"]))
	{
		/*if (!preg_match("/[^a-z0-9_.-]+/i", $_POST["login"]))
		{
      		$login_error = "Le login est invalide"; 
    	}*/
		if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))
		{
	  		$mail_error =  "Erreur adresse mail";
		}
		if (strcmp($_POST["pass"], $_POST["conf_pass"]) != 0)
		{
			$pass_error = "Le mot de passe et la confirmation ne sont pas les mêmes";
		}

		if (empty($login_error) && empty($mail_error) && empty($pass_error))
		{
			$hash = password_hash($_POST["pass"], PASSWORD_BCRYPT);

			$info = array("login" => $_POST["login"], "mail" => $_POST["mail"], "password" => $hash, "admin" => 0);

			if (addUser($info) == true)
				 header('Location: ../controllers/admin.php'); 
		}
		else
			header('Location: ../views/registration.php');

	}
	else
	{
		$general_error = "Vous devez remplir tous les champs";
		header('Location: ../views/registration.php');
	}
}