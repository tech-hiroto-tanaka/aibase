<?php

use App\Models\Area;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $areas = Area::all();
    echo "Count: " . $areas->count() . "\n";
    foreach ($areas as $area) {
        echo "ID: {$area->id}, Name: {$area->area_name}, Order: {$area->order_number}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
