<?php
include('BaseUrl.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Elevage</title>
    <link rel="stylesheet" href="public/assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <?php include("sidebar.php"); ?>
        <main class="content">
            <header>
                <h1>Tableau de Bord</h1>
            </header>
            <main>
                <?php include($page.".php") ?> 
            </main>
        </main>
    </div>
</body>
</html>
