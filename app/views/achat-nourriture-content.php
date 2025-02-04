<div class="header">
    <h1><i class="fa fa-shopping-cart"></i> Achat nourriture</h1>
</div>
<form action="<?= $url ?>/nourritures/traitementAchat" method="post">
    <div class="input-container">
        <i class="fa fa-lemon-o"></i>
        <label for="idNourriture">Nourriture</label>
        <select name="idNourriture" required>
            <?php foreach ($nourritures as $nourriture): ?>
                <option value="<?= $nourriture['id'] ?>"><?= $nourriture['NomNourriture'] ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>

    <div class="input-container">
        <i class="fa fa-cogs"></i>
        <label for="Quantite">Quantité</label>
        <input type="number" name="Quantite" required><br>
    </div>

    <!-- <div class="input-container">
        <i class="fa fa-dollar-sign"></i>
        <label for="PrixUnitaire">Prix unitaire</label>
        <input type="number" name="PrixUnitaire" required><br>
    </div> -->

    <div class="input-container">
        <i class="fa fa-calendar"></i>
        <label for="DateAchat">Date d'achat</label>
        <input type="date" name="DateAchat" required><br>
    </div>

    <input type="submit" value="Acheter" class="btn-submit">
</form>