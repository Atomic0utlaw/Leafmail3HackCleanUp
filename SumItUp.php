<?php

// Path to the output HTML file
$outputFile = 'Output.html';

// Read the content of the output file
$outputContent = file_get_contents($outputFile);

// Check if the file was read successfully
if ($outputContent === false) {
    die("Error reading the output file.\n");
}

// Use regular expression to extract directories up to two levels deep
preg_match_all('/Dry run: Infected file detected: \.\/([\w\-\/]+)\.php/', $outputContent, $matches);

// Check if there are any matches
if (empty($matches[1])) {
    die("No infected files found in the output file.\n");
}

// Array to hold directories
$directories = [];

// Loop through the matches and extract directories up to two levels deep
foreach ($matches[1] as $file) {
    // Split the file path into parts
    $parts = explode('/', $file);
    
    // Only consider the first two parts of the path
    if (count($parts) >= 2) {
        $dirPath = $parts[0] . '/' . $parts[1];

        // Add the directory to the list if it's not already added
        if (!in_array($dirPath, $directories)) {
            $directories[] = $dirPath;
        }
    }
}

// Output the directories in a more readable format
echo "<pre>";  // Use <pre> for better spacing and readability

foreach ($directories as $dir) {
    echo "Infected files detected in: ./$dir\n";
}

echo "</pre>";

?>
