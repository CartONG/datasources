<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CarteONG</title>
        <link href="../views/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../views/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
            <div id="connect" class="col-md-2">
                <div class="sub-title">
                    <h2>Connexion</h2>
                </div>
                <div>
                    <?php
                        if (!empty($general_error))
                                echo '<p class="error_connection">'.$general_error.'</p>';
                    ?>
                	<form method="POST" action="../controllers/connection.php">
                		<input name="login" type="text" class="form-control" placeholder="Login" required="required">
                		<input name="pass" type="password" class="form-control" placeholder="Mot de passe" required="required">
                		<input type="submit" class="btn btn-default" value="Envoyer">
                	</form>
                </div>
            </div>
    </body>
    <script type="text/javascript" src="../views/js/jquery.min.js"></script>
    <script type="text/javascript" src="../views/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../views/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../views/js/main.js"></script>
</html>
