<?php
return [
    'cloud_url' => env('CLOUDINARY_URL'),
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET', 'ml_default'),
    'url' => [
        'secure' => true,
        'sign_url' => false,
    ],
    // Tambahkan ini jika menggunakan library tertentu untuk bypass SSL di lokal
    'provisionary_cache_usage' => false, 
];