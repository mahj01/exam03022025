<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi d'Élevage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            margin: 20px;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .dashboard > div {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
        }

        input[type="date"] {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h1>Suivi d'Élevage - Dashboard</h1>
    </header>

    <div class="container">
        <div class="dashboard">
            <div>
                <?php include('situation-actuelle.php'); ?>
            </div>
            <div>
                <h3>Choisir une date</h3>
                <input type="date" id="date-picker" value="2025-02-03">
                <button class="btn" onclick="updateDashboard()">Mettre à jour</button>
            </div>
        </div>

        <h3>Tableau des Animaux</h3>
        <table>
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Poids Min de Vente (kg)</th>
                    <th>Poids Max (kg)</th>
                    <th>Prix de Vente (€/kg)</th>
                    <th>Jours sans manger avant de mourir</th>
                    <th>% de perte de poids/jour</th>
                    <th>Poids Actuel (kg)</th>
                    <th>Valeur Totale (€)</th>
                </tr>
            </thead>
            <tbody id="animals-table">
                <tr>
                    <td>Boeuf 1</td>
                    <td>400</td>
                    <td>600</td>
                    <td>5.00</td>
                    <td>10</td>
                    <td>1</td>
                    <td>550</td>
                    <td>2750</td>
                </tr>
                <tr>
                    <td>Boeuf 2</td>
                    <td>300</td>
                    <td>500</td>
                    <td>4.80</td>
                    <td>12</td>
                    <td>0.8</td>
                    <td>450</td>
                    <td>2160</td>
                </tr>
                <tr>
                    <td>Boeuf 3</td>
                    <td>350</td>
                    <td>550</td>
                    <td>5.20</td>
                    <td>9</td>
                    <td>1.2</td>
                    <td>450</td>
                    <td>2340</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function updateDashboard() {
            const selectedDate = document.getElementById("date-picker").value;
            console.log("Mise à jour pour la date:", selectedDate);

            // Exemple de calculs (simulé ici avec des données statiques)
            const capitalInitial = 10000;
            const animals = [
                { name: "Boeuf 1", pricePerKg: 5.00, weight: 550 },
                { name: "Boeuf 2", pricePerKg: 4.80, weight: 450 },
                { name: "Boeuf 3", pricePerKg: 5.20, weight: 450 }
            ];

            // Calcul du capital actuel
            let capitalActuel = capitalInitial;
            let totalWeight = 0;
            let nbAnimals = animals.length;
            let totalValue = 0;

            animals.forEach(animal => {
                totalWeight += animal.weight;
                totalValue += animal.weight * animal.pricePerKg;
            });

            capitalActuel += totalValue; // Ajout de la valeur des animaux à l'élevage

            // Mise à jour de l'interface
            document.getElementById("capital").textContent = capitalActuel.toFixed(2);
            document.getElementById("total-weight").textContent = totalWeight;
            document.getElementById("nb-animals").textContent = nbAnimals;

            // Mise à jour des valeurs dans le tableau des animaux
            const animalsTable = document.getElementById("animals-table");
            animalsTable.innerHTML = "";
            animals.forEach(animal => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${animal.name}</td>
                    <td>400</td>
                    <td>600</td>
                    <td>${animal.pricePerKg}</td>
                    <td>10</td>
                    <td>1</td>
                    <td>${animal.weight}</td>
                    <td>${(animal.weight * animal.pricePerKg).toFixed(2)}</td>
                `;
                animalsTable.appendChild(row);
            });
        }

        // Appel initial pour afficher la situation actuelle
        updateDashboard();
    </script>
</body>
</html>
