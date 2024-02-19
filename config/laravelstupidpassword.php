<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Config
    |--------------------------------------------------------------------------
    |
    | Various variables
    |
    */

    'environmentals' => env('PASSWORD_ENVIRONMENTALS', [
        'ork4'
    ]),
    'options' => env('PASSWORD_OPTIONS', [
        'disable' => [
            'special'
        ]
    ]),

];
