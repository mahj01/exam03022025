<h1>Stock des nourritures</h1>
<table border="1" id="datatablesSimple">
    <thead>
        <tr>
            <th>Nom nourriture</th>
            <th>Quantite restant</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stockNourriture as $stock): ?>
            <tr>
                <td><?= $stock['nom'] ?></td>
                <td><?= $stock['qte_restant'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
