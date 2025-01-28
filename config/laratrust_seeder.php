<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [],
        'owner' => [
            "Manage-Classes" => true,
            "Nursery-Profile" => true,
            "Meals" => true,
            "Newsletter" => true,
            "Nursery-Policy" => true,
            "Faq" => true,
            "Payment-Bills" => true,
            "Payment-Request" => true,
            "Admins" => true,
            "Subjects" => true,
            "Schedule" => true,
            "Chats" => true,
        ],
        'manager' => [],
        'admin' => [],
        'teacher' => [],
        'parent' => [],
    ],

    'permissions_map' => [],
];
