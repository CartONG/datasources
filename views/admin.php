<?php include_once ("header.php") ?>
<div id="page-admin">
	<h2>Administration</h2>
	<div class="table-admin-user">
		<h3>Gestion des utilisateurs</h3>
		<a href="../views/registration.php"><button id="button-add-usr" class="btn btn-primary">Ajouter un utilisateur</button></a>
		<?php echo $error?>
		<div class="panel panel-default">
	        <table class="table  table-hover">
	            <tr>
	                <th>Login</th>
	                <th>Adresse mail</th>
	                <th>Date d'inscription</th>
	                <th>Action</th>
	            </tr>
	            <?php
	                foreach ($user as $u)
	                {
	                	if ($u["admin"] != true)
	                	{
		                    echo "<tr id='user-".$u['id']."'>";
		                    echo "<td>".$u['login']."</td>";
		                    echo "<td>".$u['mail']."</td>";
		                    echo "<td>".$r['date_inscription']."</td>";
		                    echo "<td><button onclick='removeUser(".$u['id'].")' type='button' class='btn btn-danger'>Supprimer</button></td>";
		                    echo "</tr>";
	                	}
	                } 
	            ?>
	        </table>
	    </div>
    </div>


    <div class="table-admin-user">
		<h3>Liste des système de projection</h3>
		<button id="button-add-usr" class="btn btn-primary" data-toggle="modal" data-target="#modal-sp">Ajouter un système de projection</button>

		<!-- modal-content sp -->
			<div id="modal-sp" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ajouter un systeme de projection</h4>
						</div>
						<div class="modal-body">
							<input id="sp-input-name" type="text" class="form-control" placeholder="Systeme de projection">
							<input id="sp-input-epsg" type="text" class="form-control" placeholder="Epsg">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							<button onclick="addCat('sp')" type="button" class="btn btn-primary">Enregistrer</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal-end -->

		<div class="panel panel-default">
	        <table id="table-sp" class="table  table-hover">
	            <tr>
	                <th>Nom</th>
	                <th>EPSG</th>
	                <th>Action</th>
	            </tr>
	            <?php
	                foreach ($sp as $s)
	                {
	                ?>
	                	<tr id='<?php echo "sp-".$s['ID'].""?>'>
		                <td><?php echo $s['Systeme_projection']; ?></td>
		                <td><?php echo $s['EPSG']; ?></td>
	                    <td><button onclick="removeCat(<?php echo $s['ID'] ?>, 'sp')" type='button' class='btn btn-danger'>Supprimer</button></td>
	                    </tr>
	                <?php
	                } 
	            ?>
	        </table>
	    </div>
    </div>


    <div id="table-admin-cat">
	    <div id="admin-theme" class="table-admin">
			<h3>Liste des thématiques</h3>
			<button id="button-add-usr" class="btn btn-primary" data-toggle="modal" data-target="#modal-t">Ajouter une thématique</button>

			<!-- modal-content theme -->
			<div id="modal-t" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ajouter une thematique</h4>
						</div>
						<div class="modal-body">
							<input id="t-input-name" type="text" class="form-control" placeholder="Thematique">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							<button onclick="addCat('t')" type="button" class="btn btn-primary">Enregistrer</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal-end -->

			<div class="panel panel-default">
		        <table id="table-t" class="table  table-hover">
		            <tr>
		                <th>Nom</th>
		                <th>Action</th>
		            </tr>
		            <?php
		                foreach ($theme as $t)
		                {
		                ?>
		                	<tr id='<?php echo "t-".$t['ID'].""?>'>
			                <td><?php echo $t['Theme']; ?></td>
		                    <td><button onclick="removeCat(<?php echo $t['ID'] ?>, 't')" type='button' class='btn btn-danger'>Supprimer</button></td>
		                    </tr>
		                <?php
		                } 
		            ?>
		        </table>
		    </div>
	    </div>


	    <div id="admin-echelle" class="table-admin">
			<h3>Liste des echelles de représentation</h3>
			<button id="button-add-usr" class="btn btn-primary" data-toggle="modal" data-target="#modal-e">Ajouter une echelle</button>

			<!-- modal-content echelle -->
			<div id="modal-e" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ajouter une echelle</h4>
						</div>
						<div class="modal-body">
							<input id="e-input-name" type="text" class="form-control" placeholder="Echelle">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							<button onclick="addCat('e')" type="button" class="btn btn-primary">Enregistrer</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal-end -->

			<div class="panel panel-default">
		        <table id="table-e" class="table  table-hover">
		            <tr>
		                <th>Nom</th>
		                <th>Action</th>
		            </tr>
		            <?php
		                foreach ($echelle as $e)
		                {
		                ?>
		                	<tr id='<?php echo "e-".$e['ID'].""?>'>
			                <td><?php echo $e['Echelle']; ?></td>
		                    <td><button onclick="removeCat(<?php echo $e['ID'] ?>, 'e')" type='button' class='btn btn-danger'>Supprimer</button></td>
		                    </tr>
		                <?php
		                } 
		            ?>
		        </table>
		    </div>
	    </div>
	</div>
</div>
<?php include_once ("footer.html") ?>