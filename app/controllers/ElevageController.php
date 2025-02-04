<?php

namespace app\controllers;

use app\models\ElevageModel;
use Flight;

class ElevageController
{
    public function __construct()
    {
    }

    public function reinitialiser(){
        $nombreAnimauxAConserver = 3;
        Flight::elevageModel()->supprimerDonnees($nombreAnimauxAConserver);
        Flight::redirect('/');
    }

    public function dashboard() {
        $date = '2025-02-03';
        $transactions = Flight::transactionCaisseModel()->getTransactionsByDate($date);
        if (count($transactions) === 1 && $transactions[0]['typeId'] === 4) {
            $montantActuel = $transactions[0]['montant'];
        } else {
            $montantActuel = Flight::transactionCaisseModel()->getMontantActuel($date);
        }
        $data = ['page' => 'dashboard', 'montantActuel' => $montantActuel];
        Flight::render('template', $data);
    }

    public function goToCapital() {
        $data = ['page' => 'capital-insertion'];
        Flight::render('template', $data);
    }

    public function insertCapital() {
        $montant = Flight::request()->data->montant;
        $date = Flight::request()->data->date;
        $data = [
            'montant' => $montant,
            'dateTransaction' => $date,
            'typeId' => 4
        ];
        Flight::transactionCaisseModel()->insert($data, 'elevage_TransactionCaisse');
        Flight::redirect('/dashboard');
    }
}
