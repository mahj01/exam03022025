<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>Tableau de Bord</h1>
            <div>
                <i class="fa fa-cow fa-2x"></i>
            </div>
        </div>

        <!-- Saisie de la date -->
        <div class="date-input">
            <input type="date" id="currentDate" value="2025-02-03">
            <button onclick="updateDashboard()">
                <i class="fa fa-arrow-circle-o-up"></i> Mettre à jour
            </button>
        </div>

        <!-- Statistiques globales -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fa fa-money icon"></i>
                <div class="value" id="totalCapital"><?= $montantActuel ?></div>
                <div>Capital Total</div>
            </div>
            <div class="stat-card">
                <i class="fa fa-archive icon"></i>
                <div class="value" id="totalAnimals">5</div>
                <div>Nombre d'Animaux</div>
            </div>
            <div class="stat-card">
                <i class="fa fa-cutlery icon"></i>
                <div class="value" id="feedCost">250 €</div>
                <div>Coût Alimentation</div>
            </div>
        </div>

        <!-- Tableau des Animaux -->
        <table class="animals-table" id="animalsTable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>NomAnimal</th>
                    <th>Espece</th>
                    <th>PoidsInitial</th>
                    <th>PoidsActuel</th>
                    <th>Prix/kg</th>
                    <th>Estimation Valeur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animalData as $animal): ?>
                    <tr>
                        <td><?= $animal['id'] ?></td>
                        <td><?= $animal['NomAnimal'] ?></td>
                        <td><?= $animal['Espece'] ?></td>
                        <td><?= $animal['PoidsInitial'] ?></td>
                        <td><?= $animal['PoidsActuel'] ?></td>
                        <td><?= $animal['PrixParKg'] ?></td>
                        <td><?= $animal['EstimationValeur'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Simulation de mise à jour du tableau de bord
        function updateDashboard() {
            const currentDate = document.getElementById('currentDate').value;
            
            // Animation de mise à jour
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach(card => {
                card.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                }, 200);
            });

            // Simulation de modifications (à remplacer par une vraie logique)
            document.getElementById('totalCapital').textContent = 
                (Math.random() * 1000 + 9000).toFixed(0) + ' €';
            
            document.getElementById('feedCost').textContent = 
                (Math.random() * 100 + 200).toFixed(0) + ' €';
            
            alert('Tableau de bord mis à jour pour la date : ' + currentDate);
        }
    </script>
</body>