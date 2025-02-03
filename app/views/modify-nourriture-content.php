<form action="<?= $url ?>/nourritures/traitementModifier/<?= $nourriture['id'] ?>" method="post">
    <label for="NomNourriture">Nom de la nourriture</label>
    <input type="text" name="NomNourriture" value="<?= $nourriture['NomNourriture'] ?>" required><br>
    <label for="Quantite">Quantité</label>
    <input type="number" name="Quantite" value="<?= $nourriture['Quantite'] ?>" required><br>
    <input type="submit" value="Modifier">
</form>