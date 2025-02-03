<div>
    <h2>Liste des Nourritures</h2>
    <table>
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
                        <a href="<?= $url ?>/nourritures/edit/<?= $nourriture['id'] ?>">Modifier</a>
                        <a href="#" onclick="showConfirmDialog(<?= $nourriture['id'] ?>)">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="confirmDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeConfirmDialog()">&times;</span>
        <p>Êtes-vous sûr de vouloir supprimer cette nourriture ?</p>
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