<div class="header">
    <h1><i class="fa fa-money"></i> Ajout capital</h1>
</div>
<form action="<?= $url ?>/capital/traitement" method="post">
    <div class="input-container">
        <i class="fa fa-money"></i>
        <label for="">Montant</label>
        <input type="number" name="montant" id="">
    </div>
    <div class="input-container">
        <i class="fa fa-calendar"></i>
        <label for="">Date</label>
        <input type="date" name="date" value="2025-02-03" id="">
    </div>
    <input class="btn-submit" type="submit" value="Valider">
</form>