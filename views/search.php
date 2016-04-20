
<?php include_once ("header.php") ?>


<div id="search_tab" class="col-md-12">
    <div class="sub-title">
        <h2>Recherche</h2>
    </div>
    <div id="form-search">
        <select id="theme" name="Theme" class="search-c form-control">
            <option value="0">Toutes les thématique</option>
            <?php
                foreach ($them as $t)
                {
                    echo '<option value="'.$t["ID"].'">'.$t["Theme"].'</option>';
                }
            ?>
        </select>
        <select id="echelle" name="echelle" class="search-c form-control">
            <option value="0" selected>Toutes les echelles</option>
            <?php
            foreach ($echelle as $e)
            {
                echo '<option value="'.$e["ID"].'">'.$e["Echelle"].'</option>';
            }
        ?>
        </select>
        <select id="sp" name="sp" class="search-c form-control">
            <option value="0" selected>Tous les systemes de projection</option>
            <?php
            foreach ($sp as $s)
            {
                echo '<option value="'.$s["ID"].'">'.$s["Systeme_projection"].'</option>';
            }
        ?>
        </select>
    </div>
    <?php
        if ($_SESSION["admin"] == true)
            echo '<a id="add-provider" href="../controllers/edit.php"><button class="btn btn-success">Ajouter une organisation</button></a>';
    ?>
    <div class="panel panel-default">
        <table id="table-result" class="table  table-hover">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Type de données</th>
                <?php
                    if ($_SESSION["admin"] == true)
                        echo "<th>Action</th>"; 
                ?>
            </tr>
            <?php
                foreach ($result as $r)
                {
                    $tm = "";
                    foreach ($thPro as $th)
                    {
                        if ($th["id_fournisseur"] == $r["ID"])
                        {
                            $tm .= $th["id_thematique"];
                            $tm .= ",";
                        }
                    }
                    echo "<tr data-echelle='".$r['Echelle']."' data-sp='".$r['Systeme_projection']."' data-theme='".$tm."'>";
                    echo "<td><a href='../controllers/detail.php?id=".$r['ID']."'>".$r['Nom_structure']."</a></td>";
                    echo "<td>".$r['Description_structure']."</td>";
                    echo "<td>".$r['Type_donnee']."</td>";
                    if ($_SESSION["admin"] == true)
                        echo "<td><a href='../controllers/edit.php?id=".$r['ID']."'><button class='btn btn-primary' type='button'><span class='glyphicon glyphicon-wrench'></span></button></a>
                        <a href='../controllers/remove.php?id=".$r['ID']."'><button class='btn btn-danger' type='button'><span class='glyphicon glyphicon-remove'></span></button></td>";
                    echo "</tr>";
                } 
            ?>
        </table>
    </div>
</div>


<?php include_once ("footer.html") ?>