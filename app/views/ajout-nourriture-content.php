<form action="<?= $url ?>/nourritures/traitementAjout" method="post">
    <label for="NomNourriture">Nom de la nourriture</label>
    <input type="text" name="NomNourriture" required><br>
    <label for="Quantite">Quantité</label>
    <input type="number" name="Quantite" required><br>
    <input type="submit" value="Ajouter">
</form>