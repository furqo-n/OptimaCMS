<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\KontakController;
use Illuminate\Http\Request;

try {
    echo "Testing KontakController::dataTable...\n";

    $controller = new KontakController();
    $request = Request::create('/dashboard/admin/kontak/showdata', 'POST', [
        'draw' => 1,
        'start' => 0,
        'length' => 10,
        'search' => ['value' => '']
    ]);

    $response = $controller->dataTable($request);
    echo "Response Code: " . $response->getStatusCode() . "\n";
    echo "Content: " . $response->getContent() . "\n";

} catch (\Exception $e) {
    echo "Execution Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
