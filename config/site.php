<?php

return [

    'roles' =>[
        'admin' => 1,
        'company' => 2 ,
        'user' => 3,
    ],
    'status' => [
        'pending' => 'pending',
        'approved' => 'approved'
    ],
    'is_approved'=>[
        'pending' => 0,
        'approved'=>1,
    ],
    'role_names' =>[
        'admin' => 'admin',
        'company' => 'company',
        'user' => 'user',
    ],
    'categories'=>[
        'corporate' => 'Corporate',
        'social' => 'Social',
        'cultural' => 'Cultural',
        'musical' =>'Musical',
        'technical' => 'Technical',       
    ],
    'date_format' => 'd/m/Y',
    'time_format' => 'h:i A',
    'is_attended' => [
        'attended' => 1,
        'not_attended' => 0,
        
    ]
];


?>