<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admin = App\Models\User::where('email', 'admin@propertyhub.com')->first();
$agent = App\Models\User::where('email', 'john.agent@propertyhub.com')->first();
$buyer = App\Models\User::where('email', 'alice.buyer@example.com')->first();

echo "Admin password check: " . (Hash::check('password', $admin->password) ? 'OK' : 'FAIL') . PHP_EOL;
echo "Agent password check: " . (Hash::check('password', $agent->password) ? 'OK' : 'FAIL') . PHP_EOL;
echo "Buyer password check: " . (Hash::check('password', $buyer->password) ? 'OK' : 'FAIL') . PHP_EOL;

echo PHP_EOL . "=== Property accessors test ===" . PHP_EOL;
$p = App\Models\Property::first();
echo "Property title: " . $p->title . PHP_EOL;
echo "Property status (via accessor): " . $p->status . PHP_EOL;
echo "Property status_id: " . $p->status_id . PHP_EOL;
echo "Property image_url: " . $p->image_url . PHP_EOL;

echo PHP_EOL . "=== Approved property query ===" . PHP_EOL;
$approved = App\Models\Property::whereHas('statusRelation', fn($q) => $q->where('name', 'approved'))->count();
echo "Approved properties: " . $approved . PHP_EOL;
