<?php

use app\models\AnimalModel;
use app\models\NourritureModel;
use app\models\EspeceModel;
use app\models\TransactionCaisseModel;
use app\models\ElevageModel;
use app\models\UploadModel;
use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
$dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
$app->register('db', $pdoClass, [$dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

Flight::map('animalModel', function () {
    return new AnimalModel(Flight::db());
});

Flight::map('nourritureModel', function () {
    return new NourritureModel(Flight::db());
});
Flight::map('especeModel', function () {
    return new EspeceModel(Flight::db());
});

Flight::map('transactionCaisseModel', function () {
    return new TransactionCaisseModel(Flight::db());
});

Flight::map('elevageModel', function () {
    return new ElevageModel(Flight::db());
});

Flight::map('uploadModel', function () {
    return new UploadModel();
});
