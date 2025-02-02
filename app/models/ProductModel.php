<?php

namespace app\models;

use Flight;

class ProductModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

	public  function getProduit() {
        $produit = ['nom' => 'iphone 15', 'prix'=> 1290];
        return $produit;
    }

	public  function test() {
        $stmt = $this->db->query("SELECT * FROM etudiant");
        return $stmt->fetch();
    }

    
}