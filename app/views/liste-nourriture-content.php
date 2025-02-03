<div>
    <h2>Liste des Nourritures</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nourritures as $nourriture): ?>
                <tr>
                    <td><?= $nourriture['id'] ?></td>
                    <td><?= $nourriture['NomNourriture'] ?></td>
                    <td><?= $nourriture['Quantite'] ?></td>
                    <td>
                        <a href="<?= $url ?>/nourritures/edit/<?= $nourriture['id'] ?>">Modifier</a>
                        <a href="<?= $url ?>/nourritures/delete/<?= $nourriture['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>