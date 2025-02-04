<form action="<?= $url ?>/nourritures/traitementAchat" method="post">
    <label for="idNourriture">Nourriture</label>
    <select name="idNourriture" required>
        <?php foreach ($nourritures as $nourriture): ?>
            <option value="<?= $nourriture['id'] ?>"><?= $nourriture['NomNourriture'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="Quantite">Quantité</label>
    <input type="number" name="Quantite" required><br>
    <label for="PrixUnitaire">Prix unitaire</label>
    <input type="number" name="PrixUnitaire" required><br>
    <label for="DateAchat">Date d'achat</label>
    <input type="date" name="DateAchat" required><br>
    <input type="submit" value="Acheter">
</form>
