<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
    ->withServiceAccount('capstone-project-v-1-3-firebase-adminsdk-pdxdq-9e75b53f24.json')
    ->withDatabaseUri('https://capstone-project-v-1-3-default-rtdb.asia-southeast1.firebasedatabase.app/');


$auth = $factory->createAuth();
$database = $factory->createDatabase();
