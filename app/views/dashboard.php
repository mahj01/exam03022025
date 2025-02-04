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

        <div id="dashboard-content">
            <!-- Existing dashboard content goes here -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fa fa-money icon"></i>
                    <div class="value" id="montantActuel"><?= $montantActuel ?></div>
                    <div>Capital Total</div>
                </div>
                <div class="stat-card">
                    <i class="fa fa-archive icon"></i>
                    <div class="value" id="totalAnimals">5</div>
                    <div>Nombre d'Animaux</div>
                </div>
                <!-- <div class="stat-card">
                    <i class="fa fa-cutlery icon"></i>
                    <div class="value" id="feedCost">250 €</div>
                    <div>Coût Alimentation</div>
                </div> -->
            </div>

            <!-- Tableau des Animaux -->
            <table class="animals-table" id="datatablesSimple">
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
    </div>

    <script>
        function updateDashboard() {
            var date = document.getElementById('currentDate').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update-dashboard', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var tableBody = document.querySelector('#dashboard-content tbody');
                    tableBody.innerHTML = '';
                    response.animalData.forEach(function(animal) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${animal.id}</td>
                            <td>${animal.NomAnimal}</td>
                            <td>${animal.Espece}</td>
                            <td>${animal.PoidsInitial}</td>
                            <td>${animal.PoidsActuel}</td>
                            <td>${animal.PrixParKg}</td>
                            <td>${animal.EstimationValeur}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                    document.querySelector('#montantActuel').innerText = response.montantActuel;
                }
            };
            xhr.send('date=' + encodeURIComponent(date));
        }
    </script>
</body>