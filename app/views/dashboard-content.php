<div>
    <h2>Montant Actuel: <span id="montantActuel"><?= $montantActuel ?></span></h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Animal</th>
                <th>Espèce</th>
                <th>Poids Initial</th>
                <th>Poids Actuel</th>
                <th>Estimation Valeur</th>
                <th>Prix Par Kg</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animalData as $animal): ?>
                <tr>
                    <td><?= $animal['id'] ?></td>
                    <td><?= $animal['NomAnimal'] ?></td>
                    <td><?= $animal['Espece'] ?></td>
                    <td><?= $animal['PoidsInitial'] ?></td>
                    <td><?= $animal['PoidsActuel'] ?></td>
                    <td><?= $animal['EstimationValeur'] ?></td>
                    <td><?= $animal['PrixParKg'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
