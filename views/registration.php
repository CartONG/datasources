<?php
    include_once ("header.php");
    
    session_start();

    if ($_SESSION["admin"] != true)
        header('Location: ../index.php');
?>

<div class="row">
    <div class="sub-title">
        <h2>Ajouter un utilisateur</h2>
    </div>
    <div>
        <?php
            if (!empty($general_error))
                    echo '<p class="error_connection">'.$general_error.'</p>';
        ?>
    	<form method="post" action="../controllers/registration.php">
            <?php
                if (!empty($login_error))
                    echo '<p class="error_connection">'.$login_error.'</p>';
            ?>
    		<input name="login" type="text" class="form-control" placeholder="Login" required="required">
            <?php
                if (!empty($mail_error))
                    echo '<p class="error_connection">'.$mail_error.'</p>';
            ?>
    		<input name="mail" type="email" class="form-control" placeholder="Adresse mail" required="required">
            <?php
                if (!empty($pass_error))
                    echo '<p class="error_connection">'.$pass_error.'</p>';
            ?>
    		<input name="pass" type="password" class="form-control" placeholder="Mot de passe" required="required">
    		<input name="conf_pass" type="password" class="form-control" placeholder="Confirmer le mot de passe" required="required">
    		<input type="submit" class="btn btn-default" value="Envoyer">
    	</form>
    </div>
</div>


<?php include_once ("footer.html"); ?>