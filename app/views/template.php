<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - E-commerce</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.html" class="logo">E-Varotra</a>
                <ul class="menu">
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="#categorie1">Catégorie 1</a></li>
                    <li><a href="#categorie2">Catégorie 2</a></li>
                    <li><a href="#categorie3">Catégorie 3</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php include($page.'.php'); ?>
    </main>

    <footer>
        <p>&copy; 2024 E-Varotra</p>
    </footer>
</body>
</html>