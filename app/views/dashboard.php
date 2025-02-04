
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
                    <div class="value" id="totalAnimals"><?= $animalVivant ?></div>
                    <div>Nombre d'Animaux vivants</div>
                </div>
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
                            <td><a href="#" onclick="showAnimalDetails(<?= $animal['id'] ?>)"><?= $animal['id'] ?></a></td>
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

    <!-- Modal Dialog -->
    <div id="animalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="animalDetails"></div>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000; /* Ensure the modal is in the foreground */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        .close {
            color: #007bff; /* Primary color of the project */
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #0056b3; /* Darker shade of the primary color */
            text-decoration: none;
        }

        .modal-content img {
            border-radius: 10px;
            max-width: 100px; /* Limit the width */
            max-height: 100px; /* Limit the height */
        }

        .modal-content .animal-info {
            margin-top: 20px;
        }

        .modal-content .animal-info ul {
            list-style-type: none;
            padding: 0;
        }

        .modal-content .animal-info ul li {
            margin-bottom: 10px;
        }

        .modal-content .animal-info ul li strong {
            color: #007bff; /* Primary color of the project */
        }
    </style>

    <script>
        function updateDashboard() {
            var date = document.getElementById('currentDate').value;
            <?php Flight::animalModel()->simuler($date); ?>
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
                            <td><a href="#" onclick="showAnimalDetails(${animal.id})">${animal.id}</a></td>
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
                    document.querySelector('#totalAnimals').innerText = response.animalVivant;
                }
            };
            xhr.send('date=' + encodeURIComponent(date));
        }

        function showAnimalDetails(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get-animal-details?id=' + id, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var animal = JSON.parse(xhr.responseText);
                    var modalContent = `
                        <img src="<?= $url ?>/public/assets/images/1.jpg">
                        <div class="animal-info">
                            <ul>
                                <li><strong>Nom:</strong> ${animal.NomAnimal}</li>
                                <li><strong>Espèce:</strong> ${animal.Espece}</li>
                                <li><strong>Poids Initial:</strong> ${animal.PoidsInitial}</li>
                                <li><strong>Poids Actuel:</strong> ${animal.PoidsActuel}</li>
                                <li><strong>Prix/kg:</strong> ${animal.PrixParKg}</li>
                                <li><strong>Estimation Valeur:</strong> ${animal.EstimationValeur}</li>
                            </ul>
                        </div>
                    `;
                    document.getElementById('animalDetails').innerHTML = modalContent;
                    document.getElementById('animalModal').style.display = 'block';
                }
            };
            xhr.send();
        }

        function closeModal() {
            document.getElementById('animalModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('animalModal')) {
                document.getElementById('animalModal').style.display = 'none';
            }
        }
    </script>
</body>