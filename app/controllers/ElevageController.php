<?php

namespace app\controllers;

use app\models\ElevageModel;
use Flight;

class ElevageController
{
    public function __construct() {}

    public function reinitialiser()
    {
        $nombreAnimauxAConserver = 3;
        Flight::elevageModel()->supprimerDonnees($nombreAnimauxAConserver);
        Flight::redirect('/');
    }

    public function dashboard()
    {
        $date = '2025-02-03';
        $transactions = Flight::transactionCaisseModel()->getTransactionsByDate($date);

        if (count($transactions) === 1 && $transactions[0]['typeId'] === 4) {
            $montantActuel = $transactions[0]['montant'];
        } elseif (count($transactions) > 1) {
            $montantActuel = end($transactions)['montantActuel'];
        } else {
            $montantActuel = Flight::transactionCaisseModel()->getMontantActuel($date);
        }

        $animals = Flight::animalModel()->getAnimalsByDate($date);
        var_dump($animals);
        $animalData = [];
        foreach ($animals as $animal) {
            $espece = Flight::especeModel()->getEspeceById($animal['idEspece']);
            $poidsActuel = Flight::animalModel()->getPoidsActuel($animal['id']);
            $estimationValeur = Flight::animalModel()->getEstimationValeur($animal['id'], $date);
            $joursSansManger = Flight::animalModel()->getJoursSansManger($animal['id']);
            $animalData[] = [
                'id' => $animal['id'],
                'NomAnimal' => $animal['NomAnimal'],
                'Espece' => $espece['NomEspece'],
                'PoidsInitial' => $animal['PoidsInitial'],
                'PoidsActuel' => $poidsActuel,
                'EstimationValeur' => $estimationValeur,
                'PrixParKg' => $espece['PrixParKg'],
                'JoursSansManger' => $joursSansManger
            ];
        }

        $data = [
            'page' => 'dashboard',
            'montantActuel' => $montantActuel,
            'animalData' => $animalData
        ];
        Flight::render('template', $data);
    }

    public function goToCapital()
    {
        $data = ['page' => 'capital-insertion'];
        Flight::render('template', $data);
    }

    public function insertCapital()
    {
        $montant = Flight::request()->data->montant;
        $date = Flight::request()->data->date;
        $data = [
            'montant' => $montant,
            'dateTransaction' => $date,
            'typeId' => 4
        ];
        Flight::transactionCaisseModel()->insertCapital($data);
        Flight::redirect('/dashboard');
    }
}
