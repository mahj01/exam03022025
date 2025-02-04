<div class="header">
    <h1><i class="fa fa-edit"></i> Modifier espèce</h1>
</div>
<form action="<?= $url ?>/especes/traitementModifier/<?= $espece['id'] ?>" method="post">
    <div class="input-container">
        <i class="fa fa-leaf"></i>
        <label for="NomEspece">Nom de l'espèce</label>
        <input type="text" name="NomEspece" value="<?= $espece['NomEspece'] ?>" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-weight-hanging"></i>
        <label for="PoidsMinVente">Poids minimum de vente</label>
        <input type="number" name="PoidsMinVente" value="<?= $espece['PoidsMinVente'] ?>" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-weight"></i>
        <label for="PoidsMax">Poids maximum</label>
        <input type="number" name="PoidsMax" value="<?= $espece['PoidsMax'] ?>" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-dollar-sign"></i>
        <label for="PrixParKg">Prix par kilo</label>
        <input type="number" name="PrixParKg" value="<?= $espece['PrixParKg'] ?>" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-clock"></i>
        <label for="NbJoursAvantDeMourir">Nombre de jours avant de mourir</label>
        <input type="number" name="NbJoursAvantDeMourir" value="<?= $espece['NbJoursAvantDeMourir'] ?>" required><br>
    </div>

    <input type="submit" class="btn-submit" value="Modifier">
</form>
