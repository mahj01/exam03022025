<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class WelcomeController {

	public function __construct() {

	}

	public function home() {
		$produit = Flight::productModel()->getProduit();
        $data = ['nom' => $produit["nom"], 'prix'=> $produit["prix"]];
        Flight::render('welcome', $data);
    }
	public function homeDB() {
		$produit = Flight::productModel()->test();
        $data = ['nom' => $produit["nom"], 'prix'=> $produit["date_naissance"]];
        Flight::render('welcome', $data);
    }

    public function testDB() {
        $productModel = new ProductModel(Flight::db());
		$produit = $productModel->test();
        $data = ['nom' => $produit["nom"], 'prix'=> $produit["date_naissance"]];
        Flight::render('welcome', $data);
    }

    //pour tester le template
    public function homeTemplate() {
        $data = ['page' => "home"];
        Flight::render('template', $data);
    }

    //pour tester le template
    public function productTemplate() {
        $data = ['page' => "product"];
        Flight::render('template', $data);
    }
}