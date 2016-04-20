<?php include_once ("header.php") ?>

<div  id="form-edit">
    <div class="sub-title">
    <?php
    	if ($res != false)
        	echo "<h2>Modification</h2>";
        else
        	echo "<h2>Ajouter une nouvelle organisation</h2>"
    ?>
    </div>
    <div>
    	<form method="POST" action="../controllers/edit.php">
    		<input name="id" type="text" class="hidden" value="<?php echo $res["ID"] ?>">
    		<input class="form-control" name="name" type="text" placeholder="Nom de l'organisation" value="<?php echo $res["Nom_structure"]?>" required="required">
    		<input class="form-control" name="url" type="url" placeholder="Site" value="<?php echo $res["Site"]?>" required="required">
    		<input class="form-control" name="data_type" type="text" placeholder="Type de donnée" value="<?php echo $res["Type_donnee"]?>">
            <label>Thématique :</label>
    		<select class="form-control" name="theme[]" multiple>
    			<?php
    				foreach ($theme as $t)
    				{
    					echo '<option';
    					if (in_array($t["ID"], $res["theme"]))
    						echo ' selected';
    					echo ' value="'.$t["ID"].'">'.$t["Theme"].'</option>';
    				}
    			?>
    		</select>
    		<select class="form-control" name="echelle">
    			<option value="">Echelle</option>
    			<?php
    				foreach ($echelle as $e)
    				{
    					echo '<option';
    					if ($e["ID"] == $res["Echelle_id"])
    						echo ' selected';
    					echo ' value="'.$e["ID"].'">'.$e["Echelle"].'</option>';
    				}
    			?>
    		</select>
    		<select class="form-control" name="sp">
    			<option value="">Systeme de projection</option>
    			<?php
    				foreach ($sp as $s)
    				{
    					echo '<option';
    					if ($s["ID"] == $res["Systeme_projection_id"])
    						echo ' selected';
    					echo ' value="'.$s["ID"].'">'.$s["Systeme_projection"].'</option>';
    				}
    			?>
    		</select>
            <label>Description :</label>
            <textarea name="description" class="form-control"  required="required"><?php echo $res["Description_structure"]?></textarea>
    		<input id="form-edit-submit" class="btn btn-primary" type="submit" value="Envoyer">
    	</form>
    </div>
</div>


<?php include_once ("footer.html") ?>