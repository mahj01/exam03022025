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
        $animalVivants = count(Flight::animalModel()-> getAllAnimalsAlive());
        $animalData = [];
        foreach ($animals as $animal) {
            $espece = Flight::especeModel()->getEspeceById($animal['idEspece']);
            $poidsActuel = Flight::animalModel()->getPoidsActuel($animal['id'])[0];
            $prixParKg = Flight::especeModel()->getPrixParKg($animal['idEspece']); // Get single value
            $estimationValeur = $poidsActuel * $prixParKg;
            $animalData[] = [
                'id' => $animal['id'],
                'NomAnimal' => $animal['NomAnimal'],
                'Espece' => $espece['NomEspece'],
                'PoidsInitial' => $animal['PoidsInitial'],
                'PoidsActuel' => $poidsActuel,
                'EstimationValeur' => $estimationValeur,
                'PrixParKg' => $prixParKg, // Use single value
            ];
        }

        $data = [
            'page' => 'dashboard',
            'montantActuel' => $montantActuel,
            'animalData' => $animalData,
            'animalVivant' => $animalVivants
        ];
        Flight::render('template', $data);
    }

    public function getAnimalDetails()
    {
        $id = Flight::request()->query->id;
        $animal = Flight::animalModel()->getAnimalById($id);
        $espece = Flight::especeModel()->getEspeceById($animal['idEspece']);
        $poidsActuel = Flight::animalModel()->getPoidsActuel($animal['id'])[0];
        $prixParKg = Flight::especeModel()->getPrixParKg($animal['idEspece']);
        $estimationValeur = $poidsActuel * $prixParKg;

        $animalDetails = [
            'id' => $animal['id'],
            'NomAnimal' => $animal['NomAnimal'],
            'Espece' => $espece['NomEspece'],
            'PoidsInitial' => $animal['PoidsInitial'],
            'PoidsActuel' => $poidsActuel,
            'PrixParKg' => $prixParKg,
            'EstimationValeur' => $estimationValeur,
            'image' => $espece['cheminImage'] // Fetch image from espece
        ];

        Flight::json($animalDetails);
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
