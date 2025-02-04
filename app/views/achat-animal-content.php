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
        <label for="Poids">Poids</label>
        <input type="number" name="Poids" required><br>
    </div>

    <div class="input-container">
        <label for="autovente">Auto Vente</label>
        <div class="radio-group">
            <label>
                <input type="radio" name="autovente" value="1" required id='trueRadio' > Oui
            </label>
            <label>
                <input type="radio" name="autovente" value="0" required id='falseRadio' > Non
            </label>
        </div>
    </div>

    <div class="input-container">
        <i class="fa fa-calendar"></i>
        <label for="DateAchat">Date d'achat</label>
        <input type="date" name="DateAchat" required><br>
    </div>

    <div class="input-container">
        <div class="dateVenteContainer">
        <i class="fa fa-calendar"></i>
        <label for="DateVente">Date de vente</label>
        <input type="date" name="DateVente" ><br>
        </div>
    </div>

    <input type="submit" class="btn-submit" value="Acheter">
</form>

<script src="<?= $url ?>/public/assets/js/venteAnimal.js"></script>


