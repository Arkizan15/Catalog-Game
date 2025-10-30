<?php
// Debug script to troubleshoot server variables and routing
echo "<h1>Debug Information</h1>";
echo "<h2>Server Variables</h2>";
echo "<pre>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "\n";
echo "SERVER_PORT: " . $_SERVER['SERVER_PORT'] . "\n";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "QUERY_STRING: " . $_SERVER['QUERY_STRING'] . "\n";
echo "</pre>";

echo "<h2>Parsed URL (from App::parseURL)</h2>";
require_once '../app/init.php';
$app = new App();
$url = $app->parseURL();
echo "<pre>";
print_r($url);
echo "</pre>";

echo "<h2>BASEURL</h2>";
echo "<p>BASEURL: " . BASEURL . "</p>";

echo "<h2>Directory Structure</h2>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>Parent Directory: " . dirname(__DIR__) . "</p>";

echo "<h2>Controller Check</h2>";
$controllers = ['Auth', 'Home', 'Catalog', 'Library', 'Admin'];
foreach ($controllers as $controller) {
    $file = '../app/controllers/' . $controller . '.php';
    echo "<p>$controller: " . (file_exists($file) ? 'Exists' : 'Not Found') . "</p>";
}
?>
