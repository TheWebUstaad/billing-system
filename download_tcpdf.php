<?php
// Script to download and set up TCPDF

$tcpdfVersion = '6.6.2';
$tcpdfUrl = "https://github.com/tecnickcom/TCPDF/archive/{$tcpdfVersion}.zip";
$zipFile = __DIR__ . '/tcpdf.zip';
$extractPath = __DIR__ . '/application/third_party/tcpdf/';

// Create directory if it doesn't exist
if (!file_exists($extractPath)) {
    mkdir($extractPath, 0777, true);
}

// Download TCPDF
echo "Downloading TCPDF...\n";
$zipContent = file_get_contents($tcpdfUrl);
file_put_contents($zipFile, $zipContent);

// Extract ZIP file
echo "Extracting files...\n";
$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($extractPath);
    $zip->close();
    
    // Move files from subfolder
    $files = glob($extractPath . "TCPDF-{$tcpdfVersion}/*");
    foreach($files as $file) {
        $name = basename($file);
        rename($file, $extractPath . $name);
    }
    
    // Remove empty directory and zip file
    rmdir($extractPath . "TCPDF-{$tcpdfVersion}");
    unlink($zipFile);
    
    echo "TCPDF has been successfully installed!\n";
} else {
    echo "Failed to extract ZIP file\n";
}
?> 