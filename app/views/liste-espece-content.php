<div class="header" style="margin-bottom: 10px;">
    <h1><i class="fa fa-list"></i> Liste des espèces</h1>
</div>
<a href="<?= $url ?>/especes/add" class="icon-link" title="Modifier">
    <i class="fa fa-plus"></i>
    Ajout espece
</a>
<table border="1" id="datatablesSimple">
    <thead>
        <tr>
            <th>NomEspece</th>
            <th>PoidsMinVente</th>
            <th>PoidsMax</th>
            <th>PrixParKg</th>
            <th>NbJoursAvantDeMourir</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!isset($especes) || empty($especes)) {
            echo "Aucune espèce trouvée.";
        } ?>
        <?php foreach ($especes as $espece) : ?>
            <tr>
                <td><?= $espece['NomEspece'] ?></td>
                <td><?= $espece['PoidsMinVente'] ?></td>
                <td><?= $espece['PoidsMax'] ?></td>
                <td><?= $espece['PrixParKg'] ?></td>
                <td><?= $espece['NbJoursAvantDeMourir'] ?></td>
                <td>
                    <a href="<?= $url ?>/especes/edit/<?= $espece['id'] ?>" class="icon-link" title="Modifier">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" onclick="showConfirmDialog(<?= $espece['id'] ?>)" class="icon-link" title="Supprimer">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<i>(Cliquer l'en tete du colonne pour trier par ce colonne).</i>

<div id="confirmDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeConfirmDialog()">&times;</span>
        <p>Êtes-vous sûr de vouloir supprimer cette espèce ?</p>
        <button id="ouibtn" onclick="confirmDelete()">Oui</button>
        <button id="nonbtn" onclick="closeConfirmDialog()">Non</button>
    </div>
</div>

<script>
    function showConfirmDialog(id) {
        document.getElementById('confirmDialog').style.display = 'block';
        window.confirmDelete = function() {
            window.location.href = "<?= $url ?>/especes/delete/" + id;
        }
    }

    function closeConfirmDialog() {
        document.getElementById('confirmDialog').style.display = 'none';
    }
</script>