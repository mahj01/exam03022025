<?php include('base-url.php') ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi d'Élevage - Navigation</title>
    <!-- Font Awesome 4 -->
    <link rel="stylesheet" href="<?= $url ?>/public/assets/css/template.css">
    <link rel="stylesheet" href="<?= $url ?>/public/assets/css/<?= $page ?>.css">
    <link rel="stylesheet" href="<?= $url ?>/public/assets/font-awesome/css/font-awesome.min.css">
</head>

<body>
    <!-- Sidebar Navigation -->
    <?php include('side-nav-bar.php') ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-wrapper">
            <?php include($page . '.php'); ?>
        </div>
    </main>
    <script src="<?= $url ?>/public/assets/js/template.js"></script>
</body>

</html>