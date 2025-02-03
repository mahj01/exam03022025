<div>
    <h1>Liste des espèces</h1>
    <table>
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
            <?php if(!isset($especes) || empty($especes)) { echo "Aucune espèce trouvée."; } ?>
            <?php foreach ($especes as $espece) : ?>
                <tr>
                    <td><?= $espece['NomEspece'] ?></td>
                    <td><?= $espece['PoidsMinVente'] ?></td>
                    <td><?= $espece['PoidsMax'] ?></td>
                    <td><?= $espece['PrixParKg'] ?></td>
                    <td><?= $espece['NbJoursAvantDeMourir'] ?></td>
                    <td>
                        <a href="especes/edit/<?= $espece['id'] ?>">Modifier</a>
                        <a href="#" onclick="showConfirmDialog(<?= $espece['id'] ?>)">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= $url ?>/especes/add">Ajouter une espèce</a>
</div>

<div id="confirmDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeConfirmDialog()">&times;</span>
        <p>Êtes-vous sûr de vouloir supprimer cette espèce ?</p>
        <button onclick="confirmDelete()">Oui</button>
        <button onclick="closeConfirmDialog()">Non</button>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

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