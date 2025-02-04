<div class="header">
    <h1><i class="fa fa-paw"></i> Achat animal</h1>
</div>
<form action="<?= $url ?>/animaux/traitementAchat" method="post">
    <div class="input-container">
        <i class="fa fa-paw"></i>
        <label for="NomAnimal">Nom de l'animal</label>
        <input type="text" name="NomAnimal" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-leaf"></i>
        <label for="Espece">Espèce</label>
        <select name="Espece" required>
            <?php foreach ($especes as $espece): ?>
                <option value="<?= $espece['id'] ?>"><?= $espece['NomEspece'] ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>

    <div class="input-container">
        <i class="fa fa-weight-hanging"></i>
        <label for="Poids">Poids</label>
        <input type="number" name="Poids" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-dollar-sign"></i>
        <label for="Prix">Prix</label>
        <input type="number" name="Prix" required><br>
    </div>

    <div class="input-container">
        <i class="fa fa-calendar"></i>
        <label for="DateAchat">Date d'achat</label>
        <input type="date" name="DateAchat" required><br>
    </div>

    <input type="submit" class="btn-submit" value="Acheter">
</form>