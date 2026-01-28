<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing Kontak Model...\n";
    $count = App\Models\Kontak::count();
    echo "Count: " . $count . "\n";
    if ($count > 0) {
        echo "First item: " . App\Models\Kontak::first()->toJson() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
