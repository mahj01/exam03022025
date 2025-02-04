<form action="<?= $url ?>/animaux/traitementAchat" method="post">
    <label for="NomAnimal">Nom de l'animal</label>
    <input type="text" name="NomAnimal" required><br>
    <label for="Espece">Espèce</label>
    <select name="Espece" required>
        <?php foreach ($especes as $espece): ?>
            <option value="<?= $espece['id'] ?>"><?= $espece['NomEspece'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="Poids">Poids</label>
    <input type="number" name="Poids" required><br>
    <label for="Prix">Prix</label>
    <input type="number" name="Prix" required><br>
    <label for="DateAchat">Date d'achat</label>
    <input type="date" name="DateAchat" required><br>
    <input type="submit" value="Acheter">
</form>
