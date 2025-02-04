<div class="header">
    <h1><i class="fa fa-leaf"></i> Ajout especes</h1>
</div>
<form action="<?= $url ?>/especes/traitementAjout" enctype="multipart/form-data" method="post">
    <div class="input-container">
        <i class="fa fa-cogs"></i>
        <label for="NomEspece">Nom de l'espèce</label>
        <input type="text" name="NomEspece" required><br>
    </div>
    <div class="input-container">
        <i class="fa fa-weight-hanging"></i>
        <label for="PoidsMinVente">Poids minimum de vente</label>
        <input type="number" name="PoidsMinVente" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-money"></i>
        <label for="prixUnitaire">Prix unitaire</label>
        <input type="number" step="0.01" name="prixUnitaire" required>
    </div>

    <div class="input-container">
        <i class="fa fa-weight"></i>
        <label for="PoidsMax">Poids maximum</label>
        <input type="number" name="PoidsMax" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-dollar-sign"></i>
        <label for="PrixParKg">Prix par kilo</label>
        <input type="number" name="PrixParKg" required><br>
    </div>

    <div class="form-group">
        <label for="photos">Télécharger une photo:</label>
        <input type="file" id="photos" name="photo">
    </div>

    <div class="input-container">
        <i class="fa fa-clock"></i>
        <label for="NbJoursAvantDeMourir">Nombre de jours avant de mourir</label>
        <input type="number" name="NbJoursAvantDeMourir" required><br>
    </div>
    <input type="submit" class="btn-submit" value="Ajouter">
</form>