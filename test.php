<?php
// This is a special file to find the exact PHP error.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debugging Test Started...</h1>";
echo "<p>Attempting to load the main configuration file...</p>";
echo "<hr>";

// Let's try to include the main initialization file.
// If there's a syntax error in 'init.php' or any file it requires,
// the error should show up on this page.
require_once 'includes/init.php';

// If the script reaches this line, it means there are no SYNTAX errors in the included files.
echo "<br><h2>Test script finished successfully!</h2>";
echo "<p>This means there are no syntax errors in your core files. The problem might be a logical error elsewhere.</p>";

?>