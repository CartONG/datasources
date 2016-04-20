<?php include_once ("header.php") ?>

    <div id="detail-page" class="row col-md-8">
    	<div id="detail">
	    	<div id="title-detail">
		        <h2><?php echo $res["Nom_structure"] ?></h2>
		        <div id="rating" data-id="<?php echo $res['ID'] ?>" data-score="<?php echo $res["Rating"] ?>"></div>
		        <?php
		        	foreach ($res["theme"] as $t)
		        	{
		        		echo '<span class="tag label label-info">'.$t.'</span>';
		        	}
		        ?>
		    </div>
		    <p><strong>Systeme de projection : </strong></p>
		    <p><?php echo $res["Systeme_projection"] ?></p>
		    <p><strong>Echelle : </strong></p>
		    <p><?php echo $res["Echelle"] ?></p>
		    <p><strong>Déscription : </strong></p>
	        <p id="detail-descr"><?php echo $res["Description_structure"] ?></p>
	        <p>Date d'enregistrement : </p>
	        <p><?php echo $res["Date_register"] ?></p>
	        <a href="<?php echo $res['Site'] ?>" target="_blank">Acceder au site de l'organisation</a>
	    </div>
        <h4>Commentaires</h4>
        <hr>
        <?php
        	foreach ($comm as $c)
        	{
        ?>
        <article class="list-comm">
        	<div class="profile-comm">
        		<p><?php echo $c["login"] ?></p>
        	</div>
        	<div class="comm-body">
				<div class="descr-fav">
					<p><?php echo $c["content"] ?></p>
				</div>
				<div class="highlight bar-fav">
					<span class="date-fav"><small>Mis en ligne le : </small></span>
					<span><small><?php echo $c["date_publish"] ?></small></span>
				</div>
			</div>
		</article>
		<?php
			}
		?>
		<button id="add-comm" class="btn btn-primary" data-toggle="modal" data-target="#modal-comm">Poster un commentaire</button>

			<!-- modal-content echelle -->
			<div id="modal-comm" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ajouter un commentaire</h4>
						</div>
						<div class="modal-body">
							<textarea data-provider="<?php echo $res['ID'] ?>" data-user="<?php session_start(); echo $_SESSION['id'] ?>" id="input-comm" class="form-control"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							<button onclick="addComm()" type="button" class="btn btn-primary">Enregistrer</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal-end -->
    </div>

<?php include_once ("footer.html") ?>