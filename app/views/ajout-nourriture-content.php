<form action="<?= $url ?>/nourritures/traitementAjout" method="post">
    <label for="NomNourriture">Nom de la nourriture</label>
    <input type="text" name="NomNourriture" required><br>
    <label for="pourcentageGain">Pourcentage de gain</label>
    <input type="number" step="0.01" name="pourcentageGain" required><br>
    <label for="idEspece">Espèce</label>
    <select name="idEspece" required>
        <?php foreach ($especes as $espece): ?>
            <option value="<?= $espece['id'] ?>"><?= $espece['NomEspece'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Ajouter">
</form>