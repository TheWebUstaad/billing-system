<?php
// Test timezone configuration
echo "<h2>Timezone Test - Pakistan Time</h2>";
echo "<hr>";

echo "<strong>Current PHP Timezone:</strong> " . date_default_timezone_get() . "<br>";
echo "<strong>Current Date/Time:</strong> " . date('Y-m-d H:i:s T') . "<br>";
echo "<strong>Current Timestamp:</strong> " . time() . "<br>";

echo "<hr>";
echo "<h3>Comparison with Other Timezones:</h3>";

// Pakistan Time
date_default_timezone_set('Asia/Karachi');
echo "<strong>Pakistan (Asia/Karachi):</strong> " . date('Y-m-d H:i:s T') . "<br>";

// UTC Time  
date_default_timezone_set('UTC');
echo "<strong>UTC:</strong> " . date('Y-m-d H:i:s T') . "<br>";

// US Eastern Time
date_default_timezone_set('America/New_York');
echo "<strong>US Eastern (America/New_York):</strong> " . date('Y-m-d H:i:s T') . "<br>";

// Reset back to Pakistan
date_default_timezone_set('Asia/Karachi');
echo "<hr>";
echo "<strong>✅ Application is now using Pakistan Standard Time!</strong><br>";
echo "<em>Delete this file after testing: test_timezone.php</em>";
?> 