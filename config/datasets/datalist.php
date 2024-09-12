<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enums
    |--------------------------------------------------------------------------
    |
    | The following enums are used in the application.
    |
    */

    'civil_status' => [
        'single' => 'Single',
        'married' => 'Married',
        'divorced' => 'Divorced',
        'widow' => 'Widow',
    ],

    'gender' => [
        'male' => 'Male',
        'female' => 'Female',
    ],

    'occupation' => [
        'student' => 'Student',
        'employee' => 'Employee',
        'unemployed' => 'Unemployed',
    ],

    'courses' => [
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSCS' => 'Bachelor of Science in Computer Science',
    ],

    'departments' => [
        'IT' => 'Information Technology',
        'CS' => 'Computer Science',
    ],

    'education_levels' => [
        'elementary' => 'Elementary',
        'juniorhighschool' => 'Junior High School',
        'seniorhighschool' => 'Senior High School',
        'college' => 'College',
        'graduate' => 'Graduate',
        'postgraduate' => 'Post Graduate',
        'phd' => 'PhD',
    ],

    'roles' => [
        'alumni' => 'Alumni',
        'cict_admin' => 'CICT Admin',
        'program_chair' => 'Program Chair',
        'alumni_coordinator' => 'Alumni Coordinator',
    ],

    'event_status' => [
        'rescheduled' => 'Rescheduled',
        'cancelled' => 'Cancelled',
        'completed' => 'Completed',
    ],
];
