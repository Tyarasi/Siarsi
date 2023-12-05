<?php

return [
'public' => [
'driver' => 'local',
'root' => public_path(),
'url' => env('APP_URL').'/storage',
'visibility' => 'public',
'max_size' => 500000000, // Ubah nilai max_size menjadi lebih besar dari 100 MB
],

];