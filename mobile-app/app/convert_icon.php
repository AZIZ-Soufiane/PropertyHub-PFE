<?php
$source = 'public/icon.jpg';
$dest = 'public/icon.png';

if (file_exists($source)) {
    $image = imagecreatefromjpeg($source);
    if ($image) {
        imagepng($image, $dest);
        imagedestroy($image);
        echo "Icon converted to PNG successfully\n";
    } else {
        echo "Failed to read JPEG image\n";
    }
} else {
    echo "Source file not found\n";
}
