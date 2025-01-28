<?php

// Get Auth User
if (!function_exists('auth_user')) {
    function auth_user()
    {
        return auth()->user();
    }
}

// Get Auth User ID
if (!function_exists('auth_user_id')) {
    function auth_user_id()
    {
        return auth()->id();
    }
}

// Nursery
if (!function_exists('nursery')) {
    function nursery()
    {
        return auth()->user()->nursery;
    }
}


// Nursery ID
if (!function_exists('nursery_id')) {
    function nursery_id()
    {
        return auth()->user()->nursery_id;
    }
}
