<form action="<?= $url ?>/nourritures/traitementModifier/<?= $nourriture['id'] ?>" method="post">
    <label for="NomNourriture">Nom de la nourriture</label>
    <input type="text" name="NomNourriture" value="<?= $nourriture['NomNourriture'] ?>" required><br>
    <label for="pourcentageGain">Pourcentage de gain</label>
    <input type="number" step="0.01" name="pourcentageGain" value="<?= $nourriture['pourcentageGain'] ?>" required><br>
    <label for="idEspece">Espèce</label>
    <select name="idEspece" required>
        <?php foreach ($especes as $espece): ?>
            <option value="<?= $espece['id'] ?>" <?= $espece['id'] == $nourriture['idEspece'] ? 'selected' : '' ?>><?= $espece['NomEspece'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Modifier">
</form>