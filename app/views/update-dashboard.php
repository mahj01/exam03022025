<?php
        $date = Flight::request()->data->date;
        FLight::animalModel()->simuler($date);
        $transactions = Flight::transactionCaisseModel()->getTransactionsByDate($date);

        if (count($transactions) === 1 && $transactions[0]['typeId'] === 4) {
            $montantActuel = $transactions[0]['montant'];
        } elseif (count($transactions) > 1) {
            $montantActuel = end($transactions)['montantActuel'];
        } else {
            $montantActuel = Flight::transactionCaisseModel()->getMontantActuel($date);
        }

        $animals = Flight::animalModel()->getAnimalsByDate($date);
        $animalVivants = count(Flight::animalModel()-> getAllAnimalsAlive());
        $animalData = [];
        foreach ($animals as $animal) {
            $espece = Flight::especeModel()->getEspeceById($animal['idEspece']);
            $poidsActuel = Flight::animalModel()->getPoidsActuel($animal['id'])[0];
            $prixParKg = Flight::especeModel()->getPrixParKg($animal['idEspece']);
            $estimationValeur = $poidsActuel * $prixParKg;
            $animalData[] = [
                'id' => $animal['id'],
                'NomAnimal' => $animal['NomAnimal'],
                'Espece' => $espece['NomEspece'],
                'PoidsInitial' => $animal['PoidsInitial'],
                'PoidsActuel' => $poidsActuel,
                'EstimationValeur' => $estimationValeur,
                'PrixParKg' => $prixParKg,
            ];
        }

        $response = [
            'montantActuel' => $montantActuel,
            'animalData' => $animalData,
            'animalVivant' => $animalVivants
        ];
        //Flight::json($response);
        echo json_encode($response);