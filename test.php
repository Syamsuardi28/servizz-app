<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$endpoints = [
    '/admin/dashboard',
    '/admin/users',
    '/technicians',
    '/order',
    '/services'
];

foreach($endpoints as $e) {
    echo "--- $e ---\n";
    $res = App\Helpers\ApiHelper::get($e);
    echo json_encode($res, JSON_PRETTY_PRINT) . "\n\n";
}
