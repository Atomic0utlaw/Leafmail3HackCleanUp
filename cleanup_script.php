<?php
// Define the directory to scan (change this to the desired directory path)
$scanDir = './*';

// Define the file containing malicious patterns (Malware.txt)
$malwareFile = 'Malware.txt';

// Dry run mode: Show results without modifying files (set this to false to actually clean the files)
$dryRun = true;

// Read patterns from the Malware.txt file
$patterns = file($malwareFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($patterns === false) {
    die("Error reading Malware.txt. Please ensure the file exists and is readable.\n");
}

// Start output buffering
ob_start();

// Function to scan and remove malicious code
function scanAndRemoveMaliciousCode($file, $patterns) {
    global $dryRun;

    $content = file_get_contents($file);
    if ($content === false) {
        echo "Error reading file: $file\n";
        return;
    }

    $originalContent = $content;
    $foundMaliciousCode = false;

    foreach ($patterns as $pattern) {
        $pattern = trim($pattern);
        if ($pattern !== '') {
            // Perform pattern match (case insensitive, dot matches newline)
            if (preg_match('/' . preg_quote($pattern, '/') . '/is', $content)) {
                // Replace the malicious code with an empty string
                $content = preg_replace('/' . preg_quote($pattern, '/') . '/is', '', $content);
                $foundMaliciousCode = true;
            }
        }
    }

    if ($foundMaliciousCode) {
        // If dry-run, just output the infected file name
        if ($dryRun) {
            // Output with a line break for readable format
            echo "<br> Dry run: Infected file detected: $file<br>";  // For Web
        } else {
            // If not dry-run, actually remove the malicious code
            file_put_contents($file, $content);
            echo "Malicious code removed from: $file<br>";
        }
    }
}

// Function to recursively scan all PHP files in the directory
function scanFiles($dir, $patterns) {
    $files = glob($dir, GLOB_BRACE);
    foreach ($files as $file) {
        if (is_dir($file)) {
            scanFiles($file . '/*', $patterns); // Recurse into subdirectories
        } elseif (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            scanAndRemoveMaliciousCode($file, $patterns); // Scan PHP file
        }
    }
}

// Start scanning the files
scanFiles($scanDir, $patterns);

// Get the content of the buffer
$output = ob_get_contents();

// End the buffer and discard any unwanted output
ob_end_clean();

// Write the output to the Output.html file
file_put_contents('Output.html', $output);

echo "Results have been saved to Output.html.\n";

?>
