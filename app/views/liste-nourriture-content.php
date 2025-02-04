<div class="header" style="margin-bottom: 10px;">
    <h1><i class="fa fa-list"></i> Liste des nourritures</h1>
</div>
<a href="<?= $url ?>/nourritures/add" class="icon-link" title="Modifier">
    <i class="fa fa-plus"></i>
    Ajout nourriture
</a>
<table border="1" id="datatablesSimple">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Pourcentage Gain</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($nourritures as $nourriture): ?>
            <tr>
                <td><?= $nourriture['id'] ?></td>
                <td><?= $nourriture['NomNourriture'] ?></td>
                <td><?= $nourriture['pourcentageGain'] ?></td>
                <td>
                    <a href="<?= $url ?>/nourritures/edit/<?= $nourriture['id'] ?>" class="icon-link" title="Modifier">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" onclick="showConfirmDialog(<?= $nourriture['id'] ?>)" class="icon-link" title="Supprimer">
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
        <p>Êtes-vous sûr de vouloir supprimer cette nourriture ?</p>
        <button id="ouibtn" onclick="confirmDelete()">Oui</button>
        <button id="nonbtn" onclick="closeConfirmDialog()">Non</button>
    </div>
</div>
<script>
let deleteId = null;

function showConfirmDialog(id) {
    deleteId = id;
    document.getElementById('confirmDialog').style.display = 'block';
}

function closeConfirmDialog() {
    document.getElementById('confirmDialog').style.display = 'none';
    deleteId = null;
}

function confirmDelete() {
    if (deleteId !== null) {
        window.location.href = "<?= $url ?>/nourritures/delete/" + deleteId;
    }
}
</script>