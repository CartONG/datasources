<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CarteONG</title>
        <link href="../views/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../views/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <nav id="nav_top" class="navbar navbar-default navbar-fixed-top">
            <div id="title">
                <h1>CarteONG</h1>
            </div>
            <div class="container">
                <form action="" class="main-navbar-search hidden-xs" method="">
                    <input id="search-input" name="search-bar" placeholder="Recherche ...">
                </form>
            </div>
            <?php
            session_start();
            if (isset($_SESSION["login"]) && isset($_SESSION["id"]))
            {
            ?>
                <div id="register">
                    <a href="../controllers/deconnection.php"><button type="button" class="btn btn-default navbar-btn navbar-right">Se deconnecter</button></a>
                    <p class="navbar-text navbar-right">Bonjour <?php echo $_SESSION["login"] ?></p>
                </div>
            <?php
            }
            else
            {
            ?>

                <div id="register">
                    <a href="../views/connection.php"><button type="button" class="btn btn-default navbar-btn navbar-right">Connexion</button></a>
                    <a href="../views/registration.php"><button type="button" class="btn btn-default navbar-btn navbar-right">Inscription</button></a>
                </div>
            <?php
            }
            ?>
        </nav>
        <div class="page">
            <div id="sidebar" class="page-sidebar left-main-container page-sidebar-fixed-left under-main-navbar">
                <ul class="main-left-navbar">
                    <li><a href="../index.php"><span class="glyphicon glyphicon-home"></span>Accueil</a></li>
                    <li><a href="../controllers/search.php"><span class="glyphicon glyphicon-search" ></span>Recherche</a></li>
                    <?php 
                    if (isset($_SESSION["login"]) && isset($_SESSION["id"]))
                    {
                        if ($_SESSION["admin"] == true)
                        {
                        ?>
                            <li><a href="../controllers/admin.php"><span class="glyphicon glyphicon-user" ></span>Administration</a></li>
                        <?php
                        }
                        else
                        {
                        ?>
                            <li><a><span class="glyphicon glyphicon-user" ></span>Mon compte</a></li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        <div id="body-content" class="page-content">