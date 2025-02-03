<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi d'Élevage</title>
    <!-- Font Awesome 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        /* En-tête */
        .header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            flex-grow: 1;
        }
        /* Formulaire de date */
        .date-input {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .date-input input, .date-input button {
            padding: 10px;
            margin: 0 10px;
        }
        /* Tableau des animaux */
        .animals-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .animals-table th, .animals-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .animals-table th {
            background-color: #3498db;
            color: white;
        }
        /* Cartes de statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .stat-card .value {
            font-size: 1.5rem;
            font-weight: bold;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
            }
            .date-input {
                flex-direction: column;
                align-items: center;
            }
            .date-input input, .date-input button {
                margin: 10px 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>Tableau de Bord d'Élevage</h1>
            <div>
                <i class="fa fa-cow fa-2x"></i>
            </div>
        </div>

        <!-- Saisie de la date -->
        <div class="date-input">
            <input type="date" id="currentDate" value="2025-02-03">
            <button onclick="updateDashboard()">
                <i class="fa fa-refresh"></i> Mettre à jour
            </button>
        </div>

        <!-- Statistiques globales -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fa fa-money icon"></i>
                <div class="value" id="totalCapital">10 000 €</div>
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
                    <th>Type</th>
                    <th>Poids Actuel</th>
                    <th>Poids Min Vente</th>
                    <th>Poids Max</th>
                    <th>Prix/kg</th>
                    <th>Jours Sans Manger</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mouton</td>
                    <td>45 kg</td>
                    <td>50 kg</td>
                    <td>80 kg</td>
                    <td>8 €</td>
                    <td>15</td>
                    <td>
                        <button><i class="fa fa-feed"></i></button>
                        <button><i class="fa fa-shopping-cart"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Chèvre</td>
                    <td>35 kg</td>
                    <td>40 kg</td>
                    <td>70 kg</td>
                    <td>7 €</td>
                    <td>12</td>
                    <td>
                        <button><i class="fa fa-feed"></i></button>
                        <button><i class="fa fa-shopping-cart"></i></button>
                    </td>
                </tr>
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
</html>