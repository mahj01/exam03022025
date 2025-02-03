<?php
include 'BaseUrl.php'

?>
<form action="<?= $url ?>/especes/traitementModifierEspece/<?= $espece['id'] ?>" method="post">
    <label for="NomEspece">Nom de l'espèce</label>
    <input type="text" name="NomEspece" value="<?= $espece['NomEspece'] ?>" required><br>
    <label for="PoidsMinVente">Poids minimum de vente</label>
    <input type="number" name="PoidsMinVente" value="<?= $espece['PoidsMinVente'] ?>" required><br>
    <label for="PoidsMax">Poids maximum</label>
    <input type="number" name="PoidsMax" value="<?= $espece['PoidsMax'] ?>" required><br>
    <label for="PrixParKg">Prix par kilo</label>
    <input type="number" name="PrixParKg" value="<?= $espece['PrixParKg'] ?>" required><br>
    <label for="NbJoursAvantDeMourir">Nombre de jours avant de mourir</label>
    <input type="number" name="NbJoursAvantDeMourir" value="<?= $espece['NbJoursAvantDeMourir'] ?>" required><br>
    <input type="submit" value="Modifier">
</form>
