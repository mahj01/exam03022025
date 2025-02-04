<div class="header">
    <h1><i class="fa fa-cutlery"></i> Ajout Nourriture</h1>
</div>
<form action="<?= $url ?>/nourritures/traitementAjout" method="post">
    <div class="input-container">
        <i class="fa fa-cogs"></i>
        <label for="NomNourriture">Nom de la nourriture</label>
        <input type="text" name="NomNourriture" required>
    </div>

    <div class="input-container">
        <i class="fa fa-percent"></i>
        <label for="pourcentageGain">Pourcentage de gain</label>
        <input type="number" step="0.01" name="pourcentageGain" required>
    </div>

    <div class="input-container">
        <i class="fa fa-leaf"></i>
        <label for="idEspece">Espèce</label>
        <select name="idEspece" required>
            <?php foreach ($especes as $espece): ?>
                <option value="<?= $espece['id'] ?>"><?= $espece['NomEspece'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" class="btn-submit" value="Ajouter">
</form>