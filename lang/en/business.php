<?php

return [
//     'service' => [
//        'business_logic_error_1' => 'This is business logic error 1.',
//        'business_logic_error_2' => 'This is business logic error 2.'
//    ],
    'auth' => [
        'login_fail'             => 'These credentials do not match our records.',
        'unauthenticated'        => 'Unauthenticated.',
        'email_unique'           => 'The email has already been taken.',
        'current_password_wrong' => 'Your current password is wrong.',
    ],
    'user' => [
        'profile_access_denied' => 'Profile is access denied.',
        'follow_yourself'       => 'You cannot follow yourself.',
        'unfollow_yourself'     => 'You cannot unfollow yourself.',
    ],
    'post' => [
        'post_access_denied'    => 'Post is access denied.',
        'comment_access_denied' => 'Post Comment is access denied.',
    ],
];
