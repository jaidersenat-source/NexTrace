<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "DB active: " . DB::connection()->getDatabaseName() . PHP_EOL;
    $rows = DB::select('SHOW TABLES LIKE "sessions"');
    echo "sessions table found: " . (count($rows) ? 'yes' : 'no') . PHP_EOL;
    if (count($rows)) {
        $count = DB::table('sessions')->count();
        echo "sessions rows: " . $count . PHP_EOL;
        print_r($rows);
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
