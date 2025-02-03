
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
                        <a href="especes/delete/<?= $espece['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= $url ?>/espece/add">Ajouter une espèce</a>
</div>