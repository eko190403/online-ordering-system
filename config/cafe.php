<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Operating Hours Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the cafe's operating hours. Orders will be disabled outside
    | these hours. Format: 'HH:MM' (24-hour format)
    |
    */

    'open_time' => env('CAFE_OPEN_TIME', '08:00'),
    'close_time' => env('CAFE_CLOSE_TIME', '22:00'),
    
    /*
    |--------------------------------------------------------------------------
    | Cafe Information
    |--------------------------------------------------------------------------
    */
    
    'name' => env('CAFE_NAME', 'Cafe D.Villa Lampung'),
    'address' => env('CAFE_ADDRESS', 'Lampung, Indonesia'),
    'phone' => env('CAFE_PHONE', ''),

];
