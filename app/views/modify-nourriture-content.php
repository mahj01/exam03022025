<div class="header">
    <h1><i class="fa fa-edit"></i> Modifier Nourriture</h1>
</div>
<form action="<?= $url ?>/nourritures/traitementModifier/<?= $nourriture['id'] ?>" method="post">
    <div class="input-container">
        <i class="fa fa-cogs"></i>
        <label for="NomNourriture">Nom de la nourriture</label>
        <input type="text" name="NomNourriture" value="<?= $nourriture['NomNourriture'] ?>" required><br>
    </div>
    <div class="input-container">
        <i class="fa fa-percent"></i>
        <label for="pourcentageGain">Pourcentage de gain</label>
        <input type="number" step="0.01" name="pourcentageGain" value="<?= $nourriture['pourcentageGain'] ?>" required><br>
    </div>
    <div class="input-container">
        <i class="fa fa-leaf"></i>
        <label for="idEspece">Espèce</label>
        <select name="idEspece" required>
            <?php foreach ($especes as $espece): ?>
                <option value="<?= $espece['id'] ?>" <?= $espece['id'] == $nourriture['idEspece'] ? 'selected' : '' ?>><?= $espece['NomEspece'] ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>
    <input type="submit" class="btn-submit" value="Modifier">
</form>