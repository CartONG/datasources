<?php

function getAllProviders()
{
	global $bdd;

	$query = 'SELECT * FROM "Fournisseurs_donnees" ORDER BY "Nom_structure" ASC;';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$listName = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
	}
	return ($listName);
}

function getProviderThematique()
{
	global $bdd;

	$query = 'SELECT * FROM "Fournisseurs_thematique";';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$res = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
	}
	return ($res);
}

function getProviderFromId($id)
{
	global	$bdd;

	$query = 'SELECT f."ID", f."Nom_structure", f."Site", f."Description_structure", f."Type_donnee", f."Date_register", f."Echelle" AS "Echelle_id", e."Echelle", f."Systeme_projection" AS "Systeme_projection_id", s."Systeme_projection", f."Rating" FROM "Fournisseurs_donnees" f LEFT JOIN "Echelle" e ON e."ID" = f."Echelle" LEFT JOIN "Systeme_projection" s ON s."ID" = f."Systeme_projection" WHERE f."ID" = '.$id.';';
	
	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$provider = $qry->fetch();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
	}
	return ($provider);
}

function getThematiqueFromIdProvider($id)
{
	global	$bdd;

	$query = 'SELECT h."ID", h."Theme" FROM "Thematique" h INNER JOIN "Fournisseurs_thematique" t ON t."id_fournisseur" = '.$id.' AND t."id_thematique" = h."ID";';
	
	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$theme = array();
		$rows = $qry->fetchAll();
		foreach ($rows as $r)
		{
			array_push($theme, $r["ID"]);
		}
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
	}
	return ($theme);
}

function getNameThematiqueFromIdProvider($id)
{
	global	$bdd;

	$query = 'SELECT h."ID", h."Theme" FROM "Thematique" h INNER JOIN "Fournisseurs_thematique" t ON t."id_fournisseur" = '.$id.' AND t."id_thematique" = h."ID";';
	
	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$theme = array();
		$rows = $qry->fetchAll();
		foreach ($rows as $r)
		{
			array_push($theme, $r["Theme"]);
		}
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
	}
	return ($theme);
}

function getAllThematique()
{
	global $bdd;

	$query = 'SELECT * FROM "Thematique" ORDER BY "Theme" ASC;';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$them = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$$e->getMessage()."";
	}
	return ($them);
}

function getAllEchelle()
{
	global $bdd;

	$query = 'SELECT * FROM "Echelle" ORDER BY "Echelle" ASC;';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$res = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$$e->getMessage()."";
	}
	return ($res);
}

function getAllSystemeProjection()
{
	global $bdd;

	$query = 'SELECT * FROM "Systeme_projection" ORDER BY "Systeme_projection" ASC;';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		$res = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$$e->getMessage()."";
	}
	return ($res);
}

function getAllFromAll($start_with)
{
	global $bdd;

	$query = 'SELECT f."ID", f."Nom_structure", g."ID", g."Mot_cle", t."ID", t."Theme" FROM "Thematique" t, "Tag" g, "Fournisseurs_donnees" f WHERE f."Nom_structure"';
	$query .= " LIKE '".strtoupper($start_with)."%'";
	$query .= ' OR g."Mot_cle"';
	$query .= " LIKE '".strtoupper($start_with)."%'";
	$query .= ' OR t."Theme"';
	$query .= " LIKE '".strtoupper($start_with)."%';";

	try
	{
		echo $query;
		$qry = $bdd->prepare($query);
		echo $qry;
		$qry->execute();
		$res = $qry->fetchAll();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$$e->getMessage()."";
	}
	return ($res);
}





function addUser($info)
{
	global $bdd;

	$query = 'INSERT INTO "Membre"(login, mail, password, admin) VALUES (:login, :mail, :password, :admin);';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute($info);
		return (true);
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}
}

function verifConnection($info)
{
	global $bdd;

	$query = 'SELECT * FROM "Membre" WHERE login = :login';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute(array("login" => $info["login"]));
		$res = $qry->fetch();

		if (password_verify($info["password"], $res["password"]))
			return ($res);
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}
}

function editProvider($info, $id = null)
{
	global $bdd;

	$e = !isset($info['echelle'])? NULL : $info['echelle'];
	$sp = !isset($info['sp'])? NULL : $info['sp'];

	if ($id == null)
	{
		$query = "SELECT insert_or_update(NULL, '".$info['description']."', '".$info['name']."', '".$info['site']."', '".$info['data_type']."', ";
		$query .= (empty($info['echelle'])? "NULL, " : "".$info['echelle'].", ");
		$query .= (empty($info['sp'])? "NULL);" : "".$info['sp'].");");
	}
	else
	{
		$query = "SELECT insert_or_update(".$id.", '".$info['description']."', '".$info['name']."', '".$info['site']."', '".$info['data_type']."', ";
		$query .= (empty($info['echelle'])? "NULL, " : "".$info['echelle'].", ");
		$query .= (empty($info['sp'])? "NULL);" : "".$info['sp'].");");
	}


	$qry = $bdd->prepare($query);
	$qry->execute();
	return $query;
}

function removeProvider($id)
{
	global $bdd;

	$query = 'DELETE FROM "Fournisseurs_donnees" WHERE "ID" = '.$id.';';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
		return (true);
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}
}

function getAllCommFromProviderId($id)
{
	global $bdd;

	$query = 'SELECT c."content", c."date_publish", m."login" From "Commentaire" c join "Membre" m on m."id" = c."id_membre" where "id_fournisseur" = '.$id.' ORDER BY "date_publish" ASC;';

	$qry = $bdd->prepare($query);
	$qry->execute();
	$res = $qry->fetchAll();

	return ($res);
}

function getAllUsers()
{
	global $bdd;

	$query = 'SELECT * FROM "Membre"';

	$qry = $bdd->prepare($query);
	$qry->execute();
	$res = $qry->fetchAll();

	return ($res);
}

function removeUser($id)
{
	global $bdd;

	$query = 'DELETE FROM "Membre" WHERE "id" = '.$id.';';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function removeSp($id)
{
	global $bdd;

	$query = 'DELETE FROM "Systeme_projection" WHERE "ID" = '.$id.';';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function removeEchelle($id)
{
	global $bdd;

	$query = 'DELETE FROM "Echelle" WHERE "ID" = '.$id.';';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function removeTheme($id)
{
	global $bdd;

	$query = 'DELETE FROM "Thematique" WHERE "ID" = '.$id.';';

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function addEchelle($name)
{
	global $bdd;

	$query = 'INSERT INTO "Echelle" ("Echelle") ';
	$query .= "VALUES ('".$name."');";

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function addThematique($name)
{
	global $bdd;

	$query = 'INSERT INTO "Thematique" ("Theme") ';
	$query .= "VALUES ('".$name."');";

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function addSp($name, $epsg)
{
	global $bdd;

	$query = 'INSERT INTO "Systeme_projection" ("Systeme_projection", "EPSG") ';
	$query .= "VALUES ('".$name."', '".$epsg."');";

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}

function updateRating($id, $score)
{
	global $bdd;

	$query = 'SELECT rating('.$id.', '.$score.');';

	try
	{
		echo "string";
		$qry = $bdd->prepare($query);
		$qry->execute();
		$res = $qry->fetch();
		return ($res);
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}
}

function addComm($content, $id_user, $id_provider)
{
	global $bdd;

	$query = 'INSERT INTO "Commentaire" ("id_fournisseur", "content", "id_membre") ';
	$query .= "VALUES (".$id_provider.", '".$content."', ".$id_user.");";

	try
	{
		$qry = $bdd->prepare($query);
		$qry->execute();
	}
	catch (PDOException $e)
	{
		echo "Un probleme est survenu : ".$e->getMessage()."";
		return (false);
	}

	return (true);
}
