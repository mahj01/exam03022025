<form action="<?= $url ?>/especes/traitementAjout" method="post">
    <label for="NomEspece">Nom de l'espèce</label>
    <input type="text" name="NomEspece" required><br>
    <label for="PoidsMinVente">Poids minimum de vente</label>
    <input type="number" name="PoidsMinVente" required><br>
    <label for="PoidsMax">Poids maximum</label>
    <input type="number" name="PoidsMax" required><br>
    <label for="PrixParKg">Prix par kilo</label>
    <input type="number" name="PrixParKg" required><br>
    <label for="NbJoursAvantDeMourir">Nombre de jours avant de mourir</label>
    <input type="number" name="NbJoursAvantDeMourir" required><br>
    <input type="submit" value="Ajouter">
</form>