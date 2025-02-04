let deleteId = null;

function showConfirmDialog(id) {
    deleteId = id;
    document.getElementById('confirmDialog').style.display = 'block';
}

function closeConfirmDialog() {
    document.getElementById('confirmDialog').style.display = 'none';
    deleteId = null;
}

function confirmDelete() {
    if (deleteId !== null) {
        window.location.href = "<?= $url ?>/nourritures/delete/" + deleteId;
    }
}