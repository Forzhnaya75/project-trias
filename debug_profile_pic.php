<?php
// debug_profile_pic.php
use App\Models\User;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$user = User::where('role', 'superadmin')->first();

if (!$user) {
    die("Superadmin user not found.\n");
}

echo "=== DEBUG INFO ===\n";
echo "Username: " . $user->username . "\n";
echo "DB 'profile_picture' value: " . $user->profile_picture . "\n";

// Check physical file in storage/app/public
$filename = $user->profile_picture;
$storagePath = storage_path('app/public/' . $filename);
echo "Storage Path (Physical): " . $storagePath . "\n";
echo "Exists in Storage? " . (file_exists($storagePath) ? "YES" : "NO") . "\n";

// Check public link
$publicPath = public_path('storage/' . $filename);
echo "Public Path (Symlink): " . $publicPath . "\n";
echo "Exists in Public? " . (file_exists($publicPath) ? "YES" : "NO") . "\n";

// Generated URL
echo "Asset URL: " . asset('storage/' . $filename) . "\n";

// Check direct URL content (simulate browser)
$url = asset('storage/' . $filename);
echo "Warning: Cannot curl local URL easily from CLI without correct host resolution, skipping curl.\n";
