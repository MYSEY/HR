<?php

return [
    'filePath' => [
        'small'         => '/uploads/files/small/',
        'original'      => '/uploads/files/original/',
    ],
    's3Path' => [
        'original' => env('DO_SPACE_URL') . env('DO_SPACE_NAME') . '/storage/uploads/files/original/'
    ],
];
